@extends('admin.layouts.app')

@section('title', 'AdminHub Admin Dashboard v2.1')
@section('page-title', 'Dashboard')

@push('styles')
<style>
		#content main .head-title .btn-download {
			height: 36px;
			padding: 0 16px;
			border-radius: 36px;
			background: var(--blue);
			color: var(--light);
			display: flex;
			justify-content: center;
			align-items: center;
			grid-gap: 10px;
			font-weight: 500;
		}

		#content main .box-info {
			display: grid;
			grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
			grid-gap: 24px;
			margin-top: 36px;
		}
		#content main .box-info li {
			padding: 24px;
			background: var(--light);
			border-radius: 20px;
			display: flex;
			align-items: center;
			grid-gap: 24px;
		}
		#content main .box-info li .bx {
			width: 80px;
			height: 80px;
			border-radius: 10px;
			font-size: 36px;
			display: flex;
			justify-content: center;
			align-items: center;
		}
		#content main .box-info li:nth-child(1) .bx {
			background: var(--light-blue);
			color: var(--blue);
		}
		#content main .box-info li:nth-child(2) .bx {
			background: var(--light-yellow);
			color: var(--yellow);
		}
		#content main .box-info li:nth-child(3) .bx {
			background: var(--light-orange);
			color: var(--orange);
		}
		#content main .box-info li .text h3 {
			font-size: 24px;
			font-weight: 600;
			color: var(--dark);
		}
		#content main .box-info li .text p {
			color: var(--dark);	
		}

		#content main .table-data {
			display: flex;
			flex-wrap: wrap;
			grid-gap: 24px;
			margin-top: 24px;
			width: 100%;
			color: var(--dark);
		}
		#content main .table-data > div {
			border-radius: 20px;
			background: var(--light);
			padding: 24px;
			overflow-x: auto;
		}
		#content main .table-data .head {
			display: flex;
			align-items: center;
			grid-gap: 16px;
			margin-bottom: 24px;
		}
		#content main .table-data .head h3 {
			margin-right: auto;
			font-size: 24px;
			font-weight: 600;
		}
		#content main .table-data .head .bx {
			cursor: pointer;
		}

		#content main .table-data .order {
			flex-grow: 1;
			flex-basis: 500px;
		}
		#content main .table-data .order table {
			width: 100%;
			border-collapse: collapse;
		}
		#content main .table-data .order table th {
			padding-bottom: 12px;
			font-size: 13px;
			text-align: left;
			border-bottom: 1px solid var(--grey);
		}
		#content main .table-data .order table td {
			padding: 16px 0;
		}
		#content main .table-data .order table tr td:first-child {
			display: flex;
			align-items: center;
			grid-gap: 12px;
			padding-left: 6px;
		}
		#content main .table-data .order table td img {
			width: 36px;
			height: 36px;
			border-radius: 50%;
			object-fit: cover;
		}
		#content main .table-data .order table tbody tr:hover {
			background: var(--grey);
		}
		#content main .table-data .order table tr td .status {
			font-size: 10px;
			padding: 6px 16px;
			color: var(--light);
			border-radius: 20px;
			font-weight: 700;
		}
		#content main .table-data .order table tr td .status.completed {
			background: var(--blue);
		}
		#content main .table-data .order table tr td .status.process {
			background: var(--yellow);
		}
		#content main .table-data .order table tr td .status.pending {
			background: var(--orange);
		}

		#content main .table-data .todo {
			flex-grow: 1;
			flex-basis: 300px;
		}
		#content main .table-data .todo .todo-list {
			width: 100%;
		}
		#content main .table-data .todo .todo-list li {
			width: 100%;
			margin-bottom: 16px;
			background: var(--grey);
			border-radius: 10px;
			padding: 14px 20px;
			display: flex;
			justify-content: space-between;
			align-items: center;
		}
		#content main .table-data .todo .todo-list li .bx {
			cursor: pointer;
		}
		#content main .table-data .todo .todo-list li.completed {
			border-left: 10px solid var(--blue);
		}
		#content main .table-data .todo .todo-list li.not-completed {
			border-left: 10px solid var(--orange);
		}
		#content main .table-data .todo .todo-list li:last-child {
			margin-bottom: 0;
		}

		#content main .menu, #content nav .menu {
			display: none;
			list-style-type: none;
			padding-left: 20px;
			margin-top: 5px;
			position: absolute;
			background-color: #f9f9f9;
			border: 1px solid #ddd;
			border-radius: 5px;
			width: 200px;
		}
		#content main .menu a , #content nav .menu a {
			color: white;
			text-decoration: none;
			display: block;
			padding: 8px 16px;
		}
		#content main .menu a:hover , #content nav .menu a:hover {
			background-color: #444;
		}
		#content main .menu-link , #content nav .menu-link {
			margin: 5px;
			padding: 10px 20px;
			font-size: 16px;
			cursor: pointer;
			text-decoration: none;
			color: #007bff;
		}
		#content main .menu-link:hover, #content nav .menu-link:hover {
			text-decoration: underline;
		}

		/* Media Query for Smaller Screens */
		@media screen and (max-width: 768px) {
			#content nav .notification-menu,
			#content nav .profile-menu {
				width: 180px;
			}
			#sidebar {
				width: 200px;
			}

			#content {
				width: calc(100% - 60px);
				left: 200px;
			}

			#content nav .nav-link {
				display: none;
			}
		}

		@media screen and (max-width: 576px) {
			#content nav .notification-menu,
			#content nav .profile-menu {
				width: 150px;
			}
			#content nav form .form-input input {
				display: none;
			}

			#content nav form .form-input button {
				width: auto;
				height: auto;
				background: transparent;
				border-radius: none;
				color: var(--dark);
			}

			#content nav form.show .form-input input {
				display: block;
				width: 100%;
			}

			#content nav form.show .form-input button {
				width: 36px;
				height: 100%;
				border-radius: 0 36px 36px 0;
				color: var(--light);
				background: var(--red);
			}

			#content nav form.show ~ .notification,
			#content nav form.show ~ .profile {
				display: none;
			}

			#content main .box-info {
				grid-template-columns: 1fr;
			}

			#content main .table-data .head {
				min-width: 420px;
			}
			#content main .table-data .order table {
				min-width: 420px;
			}
			#content main .table-data .todo .todo-list {
				min-width: 420px;
			}
		}
</style>
@endpush

@section('content')
			<div class="head-title">
				<div class="left">
					<h1>Dashboard</h1>
					<ul class="breadcrumb">
						<li>
							<a href="#">Dashboard</a>
						</li>
						<li><i class='bx bx-chevron-right' ></i></li>
						<li>
							<a class="active" href="#">Home</a>
						</li>
					</ul>
				</div>
				<a href="https://codepen.io/saglik216/pen/LEVjwBV" class="btn-download" target="_blink">
					<i class='bx bxs-cloud-download bx-fade-down-hover' ></i>
					<span class="text">V2.5 Released</span>
				</a>
			</div>

			<ul class="box-info">
				<li>
					<i class='bx bxs-calendar-check' ></i>
					<span class="text">
						<h3>1020</h3>
						<p>New Order</p>
					</span>
				</li>
				<li>
					<i class='bx bxs-group' ></i>
					<span class="text">
						<h3>2834</h3>
						<p>Visitors</p>
					</span>
				</li>
				<li>
					<i class='bx bxs-dollar-circle' ></i>
					<span class="text">
						<h3>N$2543.00</h3>
						<p>Total Sales</p>
					</span>
				</li>
			</ul>

			<div class="table-data">
				<div class="order">
					<div class="head">
						<h3>Recent Orders</h3>
						<i class='bx bx-search' ></i>
						<i class='bx bx-filter' ></i>
					</div>
					<table>
						<thead>
							<tr>
								<th>User</th>
								<th>Date Order</th>
								<th>Status</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>
									<img src="https://placehold.co/600x400/png">
									<p>Micheal John</p>
								</td>
								<td>18-10-2021</td>
								<td><span class="status completed">Completed</span></td>
							</tr>
							<tr>
								<td>
									<img src="https://placehold.co/600x400/png">
									<p>Ryan Doe</p>
								</td>
								<td>01-06-2022</td>
								<td><span class="status pending">Pending</span></td>
							</tr>
							<tr>
								<td>
									<img src="https://placehold.co/600x400/png">
									<p>Tarry White</p>
								</td>
								<td>14-10-2021</td>
								<td><span class="status process">Process</span></td>
							</tr>
							<tr>
								<td>
									<img src="https://placehold.co/600x400/png">
									<p>Selma</p>
								</td>
								<td>01-02-2023</td>
								<td><span class="status pending">Pending</span></td>
							</tr>
							<tr>
								<td>
									<img src="https://placehold.co/600x400/png">
									<p>Andreas Doe</p>
								</td>
								<td>31-10-2021</td>
								<td><span class="status completed">Completed</span></td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="todo">
					<div class="head">
						<h3>Todos</h3>
						<i class='bx bx-plus icon'></i>
						<i class='bx bx-filter' ></i>
					</div>
					<ul class="todo-list">
						<li class="completed">
							<p>Check Inventory</p>
							<i class='bx bx-dots-vertical-rounded' ></i>
						</li>
						<li class="completed">
							<p>Manage Delivery Team</p>
							<i class='bx bx-dots-vertical-rounded' ></i>
						</li>
						<li class="not-completed">
							<p>Contact Selma: Confirm Delivery</p>
							<i class='bx bx-dots-vertical-rounded' ></i>
						</li>
						<li class="completed">
							<p>Update Shop Catalogue</p>
							<i class='bx bx-dots-vertical-rounded' ></i>
						</li>
						<li class="not-completed">
							<p>Count Profit Analytics</p>
							<i class='bx bx-dots-vertical-rounded' ></i>
						</li>
					</ul>
				</div>
			</div>
@endsection