<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\ContactForm;
use App\Services\CheckFormService;
use App\Http\Requests\StoreContactRequest;

class ContactFormController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        // $contacts = ContactForm::select('id','name','title','created_at')
        // ->get();
        
        // ページネイション対応
        // $contacts = ContactForm::select('id','name','title','created_at')
        // ->paginate();
        
        // 検索対応
        $search = $request->search;
        $query = ContactForm::search($search);
        $contacts = $query->select('id','name','title','created_at')
        ->paginate();
        

        return view('contacts.index',compact('contacts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('contacts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(Request $request)
    public function store(StoreContactRequest $request)
    {
        // dd($request);
        
        ContactForm::create([
            'name' => $request->name,
            'title' => $request->title,
            'email' => $request->email,
            'url' => $request->url,
            'gender' => $request->gender,
            'age' => $request->age,
            'contact' => $request->contact,
            // 'password' => Hash::make($request->password),
        ]);

        return to_route('contacts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        $contact = ContactForm::find($id);

        $gender = CheckFormService::checkGender($contact);
        $age = CheckFormService::checkAge($contact);

        // if($contact->gender === 0){
        //     $gender = "男性";
        // }else {
        //     $gender = '女性';
        // }

        // if($contact->age === 1){$age='〜19歳';}
        // if($contact->age === 2){$age='20歳〜29歳';}
        // if($contact->age === 3){$age='30歳〜39歳';}
        // if($contact->age === 4){$age='40歳〜49歳';}
        // if($contact->age === 5){$age='50歳〜59歳';}
        // if($contact->age === 6){$age='60歳〜69歳';}



        return view('contacts.show',compact('contact','gender','age'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $contact = ContactForm::find($id);
        return view('contacts.edit',compact('contact'));


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $contact = ContactForm::find($id);
        $contact->name = $request->name;
        $contact->title = $request->title;
        $contact->email = $request->email;
        $contact->url = $request->url;
        $contact->gender = $request->gender;
        $contact->age = $request->age;
        $contact->contact = $request->contact;
        $contact->save();

        return to_route('contacts.index');



        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $contact = ContactForm::find($id);
        $contact->delete();

        return to_route('contacts.index');


    }
}
