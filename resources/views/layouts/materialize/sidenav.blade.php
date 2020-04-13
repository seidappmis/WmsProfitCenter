<!--- BEGIN: SideNav-->
<aside class="sidenav-main nav-expanded nav-lock nav-collapsible sidenav-light sidenav-active-square">
    <div class="brand-sidebar">
        <h1 class="logo-wrapper">
            <a class="brand-logo darken-1" href="/">
            <img class="hide-on-med-and-down" src="" alt="WMS SHARP Logo" style="margin: 0 8px;">
            <span class="logo-text hide-on-med-and-down">WMS SHARP</span></a><a class="navbar-toggler" href="#"><i class="material-icons">radio_button_checked</i>
            </a>
            <a class="navbar-toggler" href="#"></a>
        </h1>
    </div>
    <ul class="sidenav sidenav-collapsible leftside-navigation collapsible sidenav-fixed menu-shadow" id="slide-out" data-menu="menu-navigation" data-collapsible="menu-accordion">
        @foreach($navList as $nav)

        @if(empty($nav["url"]))
            <li class="navigation-header"><a class="navigation-header-text">{{$nav["label"]}}</a><i class="navigation-header-icon material-icons">more_horiz</i>
            </li>
        @else
            @php
            $arr_url = explode('/', $nav['url']);
            $active = Request::segment(1) == $arr_url[0] ? 'active' : '';
            @endphp

            @if(!empty($nav['childs'])) {{-- punya sub menu --}}
            
                @php
                $parent_active = false;
                foreach($nav['childs'] AS $key => $child_nav){
                    $arr_url = explode('/', $child_nav['url']);
                    $nav['childs'][$key]['active'] = '';
                    if (Request::segment(1) == $arr_url[0]) {
                        $parent_active = 'active';
                        $nav['childs'][$key]['active'] = 'active';
                    }
                }
                @endphp

                <li class="{{$parent_active}} bold"><a class="collapsible-header waves-effect waves-cyan " href="JavaScript:void(0)" tabindex="0"><i class="material-icons">{{ $nav["icon"] }}</i><span class="menu-title" data-i18n="Menu levels">{{ $nav["label"] }}</span></a>
                    <div class="collapsible-body" style="">
                        <ul class="collapsible collapsible-sub" data-collapsible="accordion">

                        @foreach($nav['childs'] AS $child_nav)
                            <li class="{{$child_nav['active']}}">
                                <a class="{{$child_nav['active']}}" href="{{ url($child_nav["url"]) }}">
                                    <i class="material-icons">{{ $child_nav["icon"] }}</i>
                                    <span data-i18n="Second level">{{ $child_nav["label"] }}</span>
                                </a>
                            </li>
                        @endforeach

                        </ul>
                    </div>
                </li>
            @else {{-- tidak punya sub menu --}}
                <li class="bold {{ $active }}"><a class="waves-effect waves-cyan {{ $active }}" href="{{ url($nav["url"]) }}"><i class="material-icons">{{ $nav["icon"] }}</i><span class="menu-title" data-i18n="">{{ $nav["label"] }}</span></a>
                </li>
            @endif

        @endif

        @endforeach
        {{-- <li class="navigation-header"><a class="navigation-header-text"></a><i class="navigation-header-icon material-icons"></i> --}}
        </ul>

    <div class="navigation-background"></div><a class="sidenav-trigger btn-sidenav-toggle btn-floating btn-medium waves-effect waves-light hide-on-large-only green darken-4" href="#" data-target="slide-out"><i class="material-icons">menu</i></a>
    
</aside>
<!-- END: SideNav -->



