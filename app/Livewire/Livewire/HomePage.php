<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Post;

class HomePage extends Component
{
    public $latestPosts;

    public function mount()
    {
        $this->latestPosts = Post::latest()->take(3)->get();
    }

    public function render()
    {
        return view('livewire.home-page');
    }
}