@extends('layouts.layout')
<div class="">

  @foreach ($response as $data)
      <p>{{ $data }}</p>

      HOME


      <a href="{{ route('logout') }}" class="nav_link"  onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();"> <i class='bx bx-log-out nav_icon'></i>
                        <span class="nav_name">Sair</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                    <input id="teste" name="teste" value="1" />
                </form>
    @endforeach

    hme
  </div>