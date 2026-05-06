@extends('layouts.main')

@section('title', '404')

@section('content')

<div class="relative font-ibm">

    <!-- 404 section -->
    <section class="relative min-h-screen bg-[url('/assets/images/event/event-404.jpg')] bg-cover bg-center flex items-end justify-center">

        <!-- Button Wrapper -->
        <div class="mb-10">
            <a href="{{ url('/') }}" class="group relative inline-flex items-center gap-2 text-xl font-semibold
                  bg-[#DC5D66] text-white px-8 py-4 rounded-xl
                  overflow-hidden transition-colors duration-300 hover:text-[#DC5D66]">                
                <span class="relative z-10 flex items-center gap-2">
                    <i class="ri-home-4-line text-2xl"></i>
                    Back To Home
                </span>                
                <span class="absolute inset-0 bg-white -translate-x-full group-hover:translate-x-0 transition-transform duration-300 ease-out rounded-xl"></span>
            </a>
        </div>
    </section>
    <!-- end 404 -->
</div>
@endsection