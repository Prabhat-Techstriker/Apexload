<?php

Namespace App\Http\Controllers;

use App\Contact;
use App\Notifications\ContactFormMessage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\ContactFormRequest;
use App\Recipient;
use App\Notifications\NewsLatter;


Class ContactsController extends Controller{

	public function show(){
        if (! Gate::allows('users_manage')) {
            return abort(401);
        }
        $users = Contact::whereNotNull('full_name')
                 ->get();
        

	   return view('contacts.contacts', compact('users'));
	}

    public function newsLatterList(){

        $users = Contact::whereNull('full_name')
                 ->get();

       return view('contacts.newslatters', compact('users'));
    }

    public function mailContactForm(ContactFormRequest $message, Recipient $recipient){   

        $contacts = Contact::create($message->all());
        $recipient->notify(new ContactFormMessage($message));
        return redirect()->back()->with('message', 'Thanks for your message! We will get back to you soon!');
    }

    public function newsLatter(ContactFormRequest $message, Recipient $recipient){   

        $contacts = Contact::create($message->all());
        $recipient->notify(new NewsLatter($message));
        return redirect()->back()->with('message', 'Thanks for registering for our email list!');
    }
}