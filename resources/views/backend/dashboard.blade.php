@extends('backend.master')

@section('title', 'Dashboard - Bagora Admin')

@section('page-header')
<div class="row align-items-center">
    <div class="col-sm-6">
        <h1 class="mb-0 fs-3">Dashboard</h1>
        <small class="text-secondary">
            Bagora ecommerce overview
        </small>
    </div>

    <div class="col-sm-6">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb float-sm-end mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ url('/admin/dashboard') }}">Home</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Dashboard
                </li>
            </ol>
        </nav>
    </div>
</div>
@endsection


@section('content')

{{-- =========================================================
    TOP KPI CARDS
========================================================= --}}
<div class="row g-3 mb-4">

    {{-- Today Orders --}}
    <div class="col-xl-3 col-md-6">
        <div class="small-box text-bg-primary">
            <div class="inner">
                <h3>{{ $todayOrders ?? 0 }}</h3>
                <p>Today's Orders</p>
            </div>

            <i class="small-box-icon bi bi-cart-check"></i>

            <a
                href="{{ url('/admin/orders') }}"
                class="small-box-footer link-light link-underline-opacity-0"
            >
                View Orders
                <i class="bi bi-arrow-right-circle ms-1"></i>
            </a>
        </div>
    </div>


    {{-- Today Sales --}}
    <div class="col-xl-3 col-md-6">
        <div class="small-box text-bg-success">
            <div class="inner">
                <h3>
                    ৳{{ number_format($todaySales ?? 0, 0) }}
                </h3>
                <p>Today's Sales</p>
            </div>

            <i class="small-box-icon bi bi-cash-stack"></i>

            <a
                href="{{ url('/admin/orders') }}"
                class="small-box-footer link-light link-underline-opacity-0"
            >
                View Sales
                <i class="bi bi-arrow-right-circle ms-1"></i>
            </a>
        </div>
    </div>


    {{-- Pending --}}
    <div class="col-xl-3 col-md-6">
        <div class="small-box text-bg-warning">
            <div class="inner">
                <h3>{{ $pendingOrders ?? 0 }}</h3>
                <p>Pending Orders</p>
            </div>

            <i class="small-box-icon bi bi-hourglass-split"></i>

            <a
                href="{{ url('/admin/orders?status=pending') }}"
                class="small-box-footer link-dark link-underline-opacity-0"
            >
                Review Orders
                <i class="bi bi-arrow-right-circle ms-1"></i>
            </a>
        </div>
    </div>


    {{-- Low Stock --}}
    <div class="col-xl-3 col-md-6">
        <div class="small-box text-bg-danger">
            <div class="inner">
                <h3>{{ $lowStockCount ?? 0 }}</h3>
                <p>Low Stock Variants</p>
            </div>

            <i class="small-box-icon bi bi-exclamation-triangle"></i>

            <a
                href="{{ url('/admin/variants?stock=low') }}"
                class="small-box-footer link-light link-underline-opacity-0"
            >
                Check Stock
                <i class="bi bi-arrow-right-circle ms-1"></i>
            </a>
        </div>
    </div>

</div>


{{-- =========================================================
    ORDER STATUS + BUSINESS STATS
========================================================= --}}
<div class="row g-3 mb-4">

    <div class="col-xl-8">

        <div class="card h-100">

            <div class="card-header d-flex align-items-center justify-content-between">

                <div>
                    <h3 class="card-title mb-0">Order Status</h3>
                    <small class="text-secondary">
                        Current order workflow
                    </small>
                </div>

                <a
                    href="{{ url('/admin/orders') }}"
                    class="btn btn-sm btn-outline-primary"
                >
                    All Orders
                </a>

            </div>


            <div class="card-body">

                <div class="row g-3">

                    @php
                        $orderStats = [
                            [
                                'label' => 'Confirmed',
                                'value' => $confirmedOrders ?? 0,
                                'icon' => 'bi-check-circle',
                                'class' => 'text-bg-primary',
                                'status' => 'confirmed',
                            ],
                            [
                                'label' => 'Processing',
                                'value' => $processingOrders ?? 0,
                                'icon' => 'bi-gear',
                                'class' => 'text-bg-info',
                                'status' => 'processing',
                            ],
                            [
                                'label' => 'Packed',
                                'value' => $packedOrders ?? 0,
                                'icon' => 'bi-box-seam',
                                'class' => 'text-bg-secondary',
                                'status' => 'packed',
                            ],
                            [
                                'label' => 'Shipped',
                                'value' => $shippedOrders ?? 0,
                                'icon' => 'bi-truck',
                                'class' => 'text-bg-warning',
                                'status' => 'shipped',
                            ],
                            [
                                'label' => 'Delivered',
                                'value' => $deliveredOrders ?? 0,
                                'icon' => 'bi-bag-check',
                                'class' => 'text-bg-success',
                                'status' => 'delivered',
                            ],
                            [
                                'label' => 'Cancelled',
                                'value' => $cancelledOrders ?? 0,
                                'icon' => 'bi-x-circle',
                                'class' => 'text-bg-danger',
                                'status' => 'cancelled',
                            ],
                        ];
                    @endphp


                    @foreach($orderStats as $stat)

                        <div class="col-md-4 col-sm-6">

                            <a
                                href="{{ url('/admin/orders?status=' . $stat['status']) }}"
                                class="text-decoration-none"
                            >

                                <div
                                    class="p-3 rounded border h-100 d-flex align-items-center gap-3"
                                >

                                    <div
                                        class="d-inline-flex align-items-center justify-content-center rounded-circle {{ $stat['class'] }}"
                                        style="width: 46px; height: 46px;"
                                    >
                                        <i class="bi {{ $stat['icon'] }} fs-5"></i>
                                    </div>


                                    <div>

                                        <div class="fs-4 fw-bold text-body">
                                            {{ $stat['value'] }}
                                        </div>

                                        <div class="text-secondary small">
                                            {{ $stat['label'] }}
                                        </div>

                                    </div>

                                </div>

                            </a>

                        </div>

                    @endforeach

                </div>

            </div>

        </div>

    </div>


    <div class="col-xl-4">

        <div class="card h-100">

            <div class="card-header">
                <h3 class="card-title mb-0">
                    Store Overview
                </h3>
            </div>


            <div class="card-body">

                <div class="d-flex justify-content-between border-bottom py-3">
                    <span class="text-secondary">
                        Total Products
                    </span>
                    <strong>
                        {{ $totalProducts ?? 0 }}
                    </strong>
                </div>


                <div class="d-flex justify-content-between border-bottom py-3">
                    <span class="text-secondary">
                        Total Variants
                    </span>
                    <strong>
                        {{ $totalVariants ?? 0 }}
                    </strong>
                </div>


                <div class="d-flex justify-content-between border-bottom py-3">
                    <span class="text-secondary">
                        Customers
                    </span>
                    <strong>
                        {{ $totalCustomers ?? 0 }}
                    </strong>
                </div>


                <div class="d-flex justify-content-between border-bottom py-3">
                    <span class="text-secondary">
                        Abandoned Checkouts
                    </span>
                    <strong class="text-danger">
                        {{ $abandonedCheckouts ?? 0 }}
                    </strong>
                </div>


                <div class="d-flex justify-content-between pt-3">
                    <span class="text-secondary">
                        Total Revenue
                    </span>
                    <strong class="text-success">
                        ৳{{ number_format($totalRevenue ?? 0, 0) }}
                    </strong>
                </div>

            </div>

        </div>

    </div>

</div>


{{-- =========================================================
    RECENT ORDERS + LOW STOCK
========================================================= --}}
<div class="row g-3 mb-4">

    {{-- Recent Orders --}}
    <div class="col-xl-8">

        <div class="card">

            <div class="card-header d-flex align-items-center justify-content-between">

                <div>
                    <h3 class="card-title mb-0">
                        Recent Orders
                    </h3>
                </div>

                <a
                    href="{{ url('/admin/orders') }}"
                    class="btn btn-sm btn-outline-primary"
                >
                    View All
                </a>

            </div>


            <div class="card-body p-0">

                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        <thead>
                            <tr>
                                <th>Order</th>
                                <th>Customer</th>
                                <th>Phone</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>


                        <tbody>

                            @forelse(($recentOrders ?? collect()) as $order)

                                @php
                                    $statusClasses = [
                                        'pending' => 'text-bg-warning',
                                        'confirmed' => 'text-bg-primary',
                                        'processing' => 'text-bg-info',
                                        'packed' => 'text-bg-secondary',
                                        'shipped' => 'text-bg-dark',
                                        'delivered' => 'text-bg-success',
                                        'cancelled' => 'text-bg-danger',
                                        'returned' => 'text-bg-danger',
                                        'failed_delivery' => 'text-bg-danger',
                                    ];

                                    $statusClass =
                                        $statusClasses[$order->order_status]
                                        ?? 'text-bg-secondary';
                                @endphp

                                <tr>

                                    <td>
                                        <a
                                            href="{{ url('/admin/orders/' . $order->id) }}"
                                            class="fw-semibold text-decoration-none"
                                        >
                                            {{ $order->order_number }}
                                        </a>
                                    </td>


                                    <td>
                                        {{ $order->customer_name }}
                                    </td>


                                    <td>
                                        {{ $order->phone }}
                                    </td>


                                    <td>
                                        <strong>
                                            ৳{{ number_format($order->grand_total, 0) }}
                                        </strong>
                                    </td>


                                    <td>
                                        <span class="badge {{ $statusClass }}">
                                            {{ ucfirst(str_replace('_', ' ', $order->order_status)) }}
                                        </span>
                                    </td>


                                    <td class="text-secondary">
                                        {{ optional($order->created_at)->format('d M Y, h:i A') }}
                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="6" class="text-center py-5 text-secondary">
                                        No orders found yet.
                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>


    {{-- Low Stock --}}
    <div class="col-xl-4">

        <div class="card">

            <div class="card-header d-flex align-items-center justify-content-between">

                <h3 class="card-title mb-0">
                    Low Stock
                </h3>

                <a
                    href="{{ url('/admin/variants') }}"
                    class="btn btn-sm btn-outline-danger"
                >
                    Manage
                </a>

            </div>


            <div class="card-body p-0">

                <div class="list-group list-group-flush">

                    @forelse(($lowStockVariants ?? collect()) as $variant)

                        <a
                            href="{{ url('/admin/variants/' . $variant->id . '/edit') }}"
                            class="list-group-item list-group-item-action"
                        >

                            <div class="d-flex justify-content-between gap-3">

                                <div>

                                    <div class="fw-semibold">
                                        {{ $variant->product->title ?? 'Product' }}
                                    </div>

                                    <small class="text-secondary">

                                        {{ $variant->sku }}

                                        @if($variant->color)
                                            • {{ $variant->color->name }}
                                        @endif

                                        @if($variant->size)
                                            • {{ $variant->size->name }}
                                        @endif

                                    </small>

                                </div>


                                <div class="text-end">

                                    <span
                                        class="badge {{ ($variant->stock ?? 0) <= 0 ? 'text-bg-danger' : 'text-bg-warning' }}"
                                    >
                                        {{ $variant->stock ?? 0 }} left
                                    </span>

                                </div>

                            </div>

                        </a>

                    @empty

                        <div class="text-center py-5 text-secondary">
                            No low-stock variants.
                        </div>

                    @endforelse

                </div>

            </div>

        </div>

    </div>

</div>


{{-- =========================================================
    QUICK ACTIONS
========================================================= --}}
<div class="card mb-4">

    <div class="card-header">
        <h3 class="card-title mb-0">
            Quick Actions
        </h3>
    </div>


    <div class="card-body">

        <div class="d-flex flex-wrap gap-2">

            <a
                href="{{ url('/admin/products/create') }}"
                class="btn btn-primary"
            >
                <i class="bi bi-plus-circle me-1"></i>
                Add Product
            </a>


            <a
                href="{{ url('/admin/categories/create') }}"
                class="btn btn-outline-primary"
            >
                <i class="bi bi-folder-plus me-1"></i>
                Add Category
            </a>


            <a
                href="{{ url('/admin/orders?status=pending') }}"
                class="btn btn-outline-warning"
            >
                <i class="bi bi-hourglass-split me-1"></i>
                Pending Orders
            </a>


            <a
                href="{{ url('/admin/checkout-drafts') }}"
                class="btn btn-outline-danger"
            >
                <i class="bi bi-cart-x me-1"></i>
                Abandoned Checkouts
            </a>


            <a
                href="{{ url('/') }}"
                target="_blank"
                class="btn btn-outline-secondary"
            >
                <i class="bi bi-box-arrow-up-right me-1"></i>
                Visit Website
            </a>

        </div>

    </div>

</div>

@endsection