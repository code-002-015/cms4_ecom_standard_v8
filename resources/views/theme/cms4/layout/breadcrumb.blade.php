@if (\Route::current()->getName() != 'home')
    <div id="page-title" class="page-title-left bg-transparent border-top border-bottom">
        <div class="clearfix">
            <div class="container-fluid">
                <h1>{{ $page->name }}</h1>
                <span>A Short Page Title Tagline</span>

                @if(isset($breadcrumb))
                    <ol class="breadcrumb">
                    @foreach($breadcrumb as $link => $url)
                        @if($loop->last)
                            <li class="breadcrumb-item active" aria-current="page">{{$link}}</li>
                        @else
                            <li class="breadcrumb-item"><a href="{{$url}}">{{$link}}</a></li>
                        @endif
                    @endforeach
                    </ol>
                @endif
            </div>
        </div>
    </div>
@endif