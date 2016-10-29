<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Contact;

use App\Group;

class ContactsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($groupid = $request->get('groupid')) {
            $contacts = Contact::where('group_id', $groupid)->orderBy('id', 'desc')->paginate(5);
        }elseif ($term = $request->get('term')) {
            $contacts = Contact::where('name', 'like', '%' . $term . '%')
                                ->orWhere('company', 'like', '%' . $term . '%')
                                ->orWhere('email', 'like', '%' . $term . '%')
                                ->orderBy('id', 'desc')->paginate(5);
        }else {
            $contacts = Contact::orderBy('id', 'desc')->paginate(5);
        }
        return view('index', compact('contacts'));
    }


    public function autocomplete(Request $request)
    {
        if ($request->ajax())
        {
            return  Contact::select(['id', 'name as value'])->where(function($query) use ($request) {
                if ( ($term = $request->get("term")) )
                {
                    $keywords = '%' . $term . '%';
                    $query->orWhere("name", 'LIKE', $keywords);
                    $query->orWhere("company", 'LIKE', $keywords);
                    $query->orWhere("email", 'LIKE', $keywords);
                }
            })
            ->orderBy('name', 'asc')
            ->take(5)
            ->get();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $groups = Group::all();
        return view('form', compact('groups'));
    }

    public function upload($file){
        $extension = $file->getClientOriginalExtension();
        $sha1 = sha1($file->getClientOriginalName());
        $filename = date('Y-m-d-h-i-s')."_".$sha1.".".$extension;
        $path = public_path('contactPhotos/photos');
        $file->move($path, $filename);
        return 'contactPhotos/photos/'.$filename;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // `id`, `group_id`, `name`, `company`, `email`, `phone`, `address`
        $this->validate($request, [
            'name' => 'required',
            'company' => 'required',
            'email' => 'required|email',
            'photo' => 'image',
        ]);


        $contact = new Contact();
        $contact->name      = $request['name'];
        $contact->email     = $request['email'];
        $contact->company   = $request['company'];
        $contact->phone     = $request['phone'];
        $contact->address   = $request['address'];
        $contact->group_id  = $request['group'];
        if (isset($request['photo'])) {
            $contact->photo     = $this->upload($request['photo']);
        }else {
            $contact->photo = 'http://placehold.it/100x100';
        }
        $contact->save();

        return redirect('contacts')->with(['message' => 'The Contact Inserted Sucessfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $groups = Group::all();

        $contact = Contact::where('id', $id)->first();

        return view('edit', ['contact' => $contact, 'groups' => $groups]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateTheContact(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'company' => 'required',
            'email' => 'required|email',
        ]);


        $contact = Contact::find($id);
        $contact->name      = $request['name'];
        $contact->email     = $request['email'];
        $contact->company   = $request['company'];
        $contact->phone     = $request['phone'];
        $contact->address   = $request['address'];
        $contact->group_id  = $request['group'];
        if (!empty($request['photo'])) {
            if ($contact->photo != 'http://placehold.it/100x100') {
                unlink(public_path($contact->photo));
            }
            $contact->photo     = $this->upload($request['photo']);
        }else {
            $photo = $contact->photo;
            $contact->photo = $photo;
        }
        $contact->save();

        return redirect('contacts')->with(['message' => 'The Contact Updated Sucessfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $contact = Contact::find($id);
        if ($contact->photo != 'http://placehold.it/100x100') {
            unlink(public_path($contact->photo));
        }
        $contact->delete();
        return redirect()->back()->with(['message' => 'The Contact Deleted Sucessfully']);
    }
}
