<?php

namespace App\Http\Controllers;

use App\Models\Member;

class MemberController extends Controller
{
    /** GET /members */
    public function index()
    {
        $members = Member::withCount(['organizedEvents', 'attendedEvents'])
            ->orderBy('name')
            ->get();

        return view('members.index', compact('members'));
    }

    /** GET /members/{member} — the page filtered by the related model */
    public function show(Member $member)
    {
        $organized = $member->organizedEvents()
            ->withCount('attendees')
            ->orderBy('starts_at')
            ->get();

        // The upcoming() scope also works through a relationship.
        $attending = $member->attendedEvents()
            ->withCount('attendees')
            ->upcoming()
            ->get();

        return view('members.show', compact('member', 'organized', 'attending'));
    }
}
