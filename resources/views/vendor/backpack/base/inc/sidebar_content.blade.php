{{-- This file is used to store sidebar items, inside the Backpack admin panel --}}
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>


<li class="nav-item"><a class="nav-link" href="{{ backpack_url('user') }}"><i class="las la-user"></i> Users</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('product') }}"><i class="las la-store-alt"></i> Products</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('order') }}"><i class="las la-shopping-cart"></i> Orders</a></li>
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('transaction') }}"><i class="las la-file-invoice-dollar"></i> Transactions</a></li>
