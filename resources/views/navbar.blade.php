<div class="topnav">
    <div class="container-fluid">
        <nav class="navbar navbar-light navbar-expand-lg topnav-menu">

            <div class="collapse navbar-collapse" id="topnav-menu-content">
                <ul class="navbar-nav">

                    <li class="nav-item">
                        <a class="nav-link active dropdown-toggle arrow-none" href="{{ route('home') }}" id="topnav-dashboard" role="button"
                        >
                            <i class="bx bx-home-circle me-2"></i><span class= key="t-dashboards">Dashboards</span> 
                        </a>
                       
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-dashboard" role="button"
                        >
                            <i class="bx bx-home-circle me-2"></i><span key="t-dashboards">User(s)</span> <div class="arrow-down"></div>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="topnav-dashboard">
                            <a href="{{ url('add-user')}}" class="dropdown-item" key="t-alerts">Add User(s)</a>
                            <a href="{{ url('show-user')}}" class="dropdown-item" key="t-alerts">Show Users</a>
                           
                        </div>
                    </li>
                  
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-dashboard" role="button"
                        >
                            <i class="bx bx-home-circle me-2"></i><span key="t-dashboards">Property_details</span> <div class="arrow-down"></div>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="topnav-dashboard">
                            {{-- <a href="{{ url('add-city')}}" class="dropdown-item" key="t-alerts">Add City</a> --}}
                            <a href="{{ url('show-city')}}" class="dropdown-item" key="t-alerts">Add-City</a>
                            <a href="{{ url('show-area')}}" class="dropdown-item" key="t-alerts">Add-Area(s)</a>
                            {{-- <a href="{{ url('show-area')}}" class="dropdown-item" key="t-alerts">Show Area(s)</a> --}}
                            <a href="{{ url('show-type')}}" class="dropdown-item" key="t-alerts">Add-Type(s)</a>
                          
                        </div>
                    </li>
                  

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-dashboard" role="button"
                        >
                            <i class="bx bx-home-circle me-2"></i><span key="t-dashboards">Property Dealer(s)</span> <div class="arrow-down"></div>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="topnav-dashboard">

                            {{-- <a href="{{ url('show-newsaler')}}" class="dropdown-item" key="t-alerts">Add-New Saler(s)</a> --}}
                            <a href="{{ url('show-saler')}}" class="dropdown-item" key="t-alerts">Add- Saler(s)</a>
                            <a href="{{ url('show-buyer')}}" class="dropdown-item" key="t-alerts">Add- Buyer(s)</a>
                            <a href="{{ url('show-property')}}" class="dropdown-item" key="t-alerts">Add- Property</a>                       
                            <a href="{{ url('show-sale-property')}}" class="dropdown-item" key="t-alerts">Sale- Property</a>                       
                           
                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-dashboard" role="button"
                        >
                            <i class="bx bx-home-circle me-2"></i><span key="t-dashboards">Inventory</span> <div class="arrow-down"></div>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="topnav-dashboard">
                            
                            <a href="{{ url('show-stocks')}}" class="dropdown-item" key="t-alerts">Stock(s)</a>
                            <a href="{{ url('show-purchases')}}" class="dropdown-item" key="t-alerts">Purchase(s)</a>
                            <a href="{{ url('show-sales')}}" class="dropdown-item" key="t-alerts">Sales</a>                       
                                  
                           
                        </div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-dashboard" role="button"
                        >
                            <i class="bx bx-home-circle me-2"></i><span key="t-dashboards">Expanses</span> <div class="arrow-down"></div>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="topnav-dashboard">

                            <a href="{{ url('show-expanses')}}" class="dropdown-item" key="t-alerts">Expanses Head(s)</a>
                            <a href="{{ url('show-expanditures')}}" class="dropdown-item" key="t-alerts">Expenditure(s)</a>
                          
                        </div>
                    </li>

                  
                    
                </ul>
            </div>
        </nav>
    </div>
</div>  