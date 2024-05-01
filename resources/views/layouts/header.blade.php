<!-- components/header.blade.php -->
<div class="container fixed-div" style="height:50px;background:orange;margin:0px auto;position:relative">
    <div class="row" style="padding:10px">
        <div class="col-md-8 logo">
            <img src="{{ asset('logo.png') }}" alt="Logo" height=33>
        </div>
        <div class="col-md-4 user-info text-right">
            @auth
            <div class="row">
                <span class="col-md-8" style="text-align:right">{{ auth()->user()->name }}</span>
                <form class="col-md-4" action="{{ route('logout') }}" method="post">
                    @csrf
                    <button type="submit" style="border-radius: 5px;border: none;">Logout</button>
                </form>
                <div>
                    @else
                    <span></span>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>