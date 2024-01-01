<?php

namespace App\Http\Controllers;

use App\Mail\ContactShared;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use function PHPUnit\Framework\assertIsNotInt;

class ContactShareController extends Controller
{
  public function create()
  {
    return view('contact-shares.create');
  }

  public function index(){
    $contactsSharedWithUser = auth()->user()->sharedContacts()->with('user')->get();
    $contactsSharedByUser = auth()
        ->user()
        ->contacts()
        ->with(['sharedWithUsers' => fn ($query) => $query->withPivot('id')])
        ->get()
        ->filter(fn($contact) => $contact->sharedWithUsers->isNotEmpty());
    return view('contact-shares.index', compact('contactsSharedWithUser','contactsSharedByUser'));
  }
  public function store(Request $request)
  {
    $data = $request->validate([
        'contact_email' => [Rule::exists('contacts', 'email')->where('user_id', auth()->id()),
            'email'],
        'user_email' => ['exists:users,email', 'email', 'not_in:' . $request->user()->email],
    ], [
        'contact_email.exists' => 'This contact does not exist on ur contacts list',
        'user_email.exists' => 'This user does not exist',
        'user_email.not_in' => 'You cannot share with yourself',
        'user_email.email' => 'The email must be a valid email',
        'contact_email.email' => 'The email must be a valid email',
    ]);

    $user = User::where('email', $data['user_email'])->first();
    $contact = Contact::where('email', $data['contact_email'])->first();

    /*if ($contact->sharedWithUsers->contains($user)) {
      return redirect('home')->with('alert', [
          'message' => 'Your contact ' . $contact->name . ' has already been shared with ' . $user->name,
          'type' => 'warning',
      ]);

    }*/

    $shareExists = $contact->sharedWithUsers()->wherePivot('user_id', $user->id)->first();


    if ($shareExists) {
      return redirect('home')->with('alert', [
          'contact_email' => 'Your contact ' . $contact->name . ' has already been shared with ' . $user->name,
          'type' => 'warning',
      ])->withErrors(
          ['contact_email'=> 'Your contact ' . $contact->name . ' has already been shared with ' . $user->name]);
    } else {
      $contact->sharedWithUsers()->attach($user);
      //Mail::to($user)->send(new ContactShared(auth()->user()->email, $contact->email));
      return redirect('home')->with('alert', [
          'message' => 'Your contact ' . $contact->name . ' has been shared with ' . $user->name,
          'type' => 'success',
      ]);
    }
  }

  public function destroy(int $contactShareId){
//    $contactShare = auth()->user()->contacts()
//        ->with(['sharedWithUsers' => fn ($q) => $q->withPivot('contact_shares.id',$contactShareId)])
//        ->get()
//        ->firstWhere(fn($contact) => $contact->sharedWithUsers->isNotEmpty());
    $contactShare = DB::selectOne('SELECT * FROM contact_shares WHERE id = ?', [$contactShareId]);
    $contact = Contact::findOrFail($contactShare->contact_id);

    abort_if($contact->user_id !== auth()->user()->id, 403);

    $contact->sharedWithUsers()->detach($contactShare->user_id);

    return redirect()->route('contact-shares.index')->with('alert', [
        'message' => 'Your contact ' . $contact->name . ' has been unshared',
        'type' => 'success',
    ]);
  }

}
