<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ContactsController extends Controller
{

    public function index():string
    {
        $contacts = Contact::query()
            ->where('user_id', '=', Auth::user()->id)
            ->orderBy('name')
            ->get();

        return response()->json($contacts);
    }


    public function create(Request $request):string
    {
        $this->validate($request, [
            'name'     => ['required', 'string', 'min:1', 'max:255'],
            'tel'      => ['nullable', 'string', 'min:1', 'max:40'],
            'email'    => ['nullable', 'email'],
            'birthday' => ['nullable', 'date'],
        ]);

        /** @var Contact $request */

        $data['name'] = $request->name;
        $data['user_id'] = Auth::user()->id;

        if ($request->tel) $data['tel'] = $request->tel;
        if ($request->email) $data['email'] = $request->email;
        if ($request->birthday) $data['birthday'] = $request->birthday;

        $contact = Contact::query()->create($data);

        return response()->json($contact);
    }


    public function update(int $id, Request $request):bool
    {
        $this->validate($request, [
            'name'     => ['required', 'string', 'min:1', 'max:255'],
            'tel'      => ['nullable', 'string', 'min:1', 'max:40'],
            'email'    => ['nullable', 'email'],
            'birthday' => ['nullable', 'date'],
        ]);

        /** @var Contact $request */

        $data['name'] = $request->name;

        if ($request->tel) $data['tel'] = $request->tel;
        if ($request->email) $data['email'] = $request->email;
        if ($request->birthday) $data['birthday'] = $request->birthday;

        return Contact::query()
            ->where('user_id', '=', Auth::user()->id)
            ->where('id', '=', $id)
            ->update($data);
    }


    public function delete(int $id):bool
    {
        return Contact::query()
            ->where('user_id', '=', Auth::user()->id)
            ->where('id', '=', $id)
            ->forceDelete();
    }


    public function search(string $keyword):string
    {
        $contacts = Contact::query()
            ->where('user_id', '=', Auth::user()->id)
            ->where(function ($query) use($keyword) {
                $query->where('name', 'like', '%' . $keyword . '%')
                    ->orWhere('tel', 'like', '%' . $keyword . '%')
                    ->orWhere('email', 'like', '%' . $keyword . '%');
            })
            ->orderByDesc('created_at')
            ->get();

        return response()->json($contacts);
    }

}
