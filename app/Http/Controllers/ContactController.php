<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Models\Contact;
use App\Services\ContactService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ContactController extends Controller
{

    /**
     * @var ContactService
     */
    private ContactService $contactService;

    public function __construct()
    {
        $this->contactService = new ContactService();
    }

    public function index()
    {

        return Inertia::render("Home", [
            'contacts'=> $this->contactService->get(request()),
            'user' => Auth::user(),
            "isLogged" => Auth::check()
        ]);
    }

    public function trashed()
    {

        return Inertia::render("Trashed", [
            'contacts'=> $this->contactService->trashed(request()),
            'user' => Auth::user(),
            "isLogged" => Auth::check()
        ]);
    }

    public function restore($id)
    {
        return $this->contactService->restore($id);
    }

    public function searchTrashed(Request $request)
    {
        return $this->contactService->trashed($request);
    }
    public function store(ContactRequest $request)
    {
        return $this->contactService->store($request);
    }

    public function search(Request $request)
    {
        return $this->contactService->get($request);
    }

    public function update(ContactRequest $request,  $id)
    {
        return $this->contactService->update($request, $id);
    }

    public function destroy($id)
    {
        return $this->contactService->destroy($id);
    }

}
