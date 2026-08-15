<!doctype html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=yes"
    >

    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >

    <title>
        @yield('title', 'Bagora Admin')
    </title>


    {{-- Favicon --}}
    <link
        rel="icon"
        href="{{ asset('backend/assets/img/favicon.png') }}"
    >


    {{-- Prevent Dark/Light Flash --}}
    <script>
        (() => {

            const STORAGE_KEY = 'lte-theme';

            let stored = null;

            try {

                stored =
                    localStorage.getItem(STORAGE_KEY);

            } catch (e) {}


            const prefersDark =
                window.matchMedia &&
                window.matchMedia(
                    '(prefers-color-scheme: dark)'
                ).matches;


            let resolved = 'light';


            if (
                stored === 'dark' ||
                stored === 'light'
            ) {

                resolved = stored;

            } else if (prefersDark) {

                resolved = 'dark';

            }


            document.documentElement.setAttribute(
                'data-bs-theme',
                resolved
            );

            document.documentElement.style.colorScheme =
                resolved;

        })();
    </script>


    {{-- Source Sans --}}
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
    >


    {{-- Overlay Scrollbars --}}
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/styles/overlayscrollbars.min.css"
    >


    {{-- Bootstrap Icons --}}
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css"
    >


    {{-- AdminLTE --}}
    <link
        rel="stylesheet"
        href="{{ asset('backend/assets/css/adminlte.css') }}"
    >


    {{-- Your Custom CSS --}}
    <link
        rel="stylesheet"
        href="{{ asset('backend/assets/css/custom.css') }}"
    >


    @stack('styles')

</head>


<body
    class="layout-fixed sidebar-expand-lg bg-body-tertiary"
>


<div class="app-wrapper">


    {{-- =====================================================
        HEADER
    ====================================================== --}}

    <nav
        class="app-header navbar navbar-expand bg-body"
    >

        <div class="container-fluid">


            {{-- LEFT HEADER --}}
            <ul class="navbar-nav">


                {{-- Sidebar Toggle --}}
                <li class="nav-item">

                    <a
                        class="nav-link"
                        data-lte-toggle="sidebar"
                        href="#"
                        role="button"
                    >

                        <i class="bi bi-list"></i>

                    </a>

                </li>


                {{-- Website --}}
                <li
                    class="nav-item d-none d-md-block"
                >

                    <a
                        href="{{ url('/') }}"
                        target="_blank"
                        class="nav-link"
                    >

                        <i
                            class="bi bi-box-arrow-up-right me-1"
                        ></i>

                        Visit Website

                    </a>

                </li>


                <li
                    class="nav-item d-none d-lg-block"
                >

                    <span
                        class="nav-link text-secondary"
                    >

                        Bagora Ecommerce

                    </span>

                </li>


            </ul>



            {{-- RIGHT HEADER --}}
            <ul class="navbar-nav ms-auto">


                {{-- Theme --}}
                <li class="nav-item dropdown">

                    <a
                        class="nav-link"
                        href="#"
                        data-bs-toggle="dropdown"
                    >

                        <i class="bi bi-circle-half"></i>

                    </a>


                    <ul
                        class="dropdown-menu dropdown-menu-end"
                    >


                        <li>

                            <button
                                type="button"
                                class="dropdown-item bagora-theme"
                                data-theme="light"
                            >

                                <i
                                    class="bi bi-sun-fill me-2"
                                ></i>

                                Light

                            </button>

                        </li>


                        <li>

                            <button
                                type="button"
                                class="dropdown-item bagora-theme"
                                data-theme="dark"
                            >

                                <i
                                    class="bi bi-moon-fill me-2"
                                ></i>

                                Dark

                            </button>

                        </li>


                        <li>

                            <button
                                type="button"
                                class="dropdown-item bagora-theme"
                                data-theme="auto"
                            >

                                <i
                                    class="bi bi-circle-half me-2"
                                ></i>

                                Auto

                            </button>

                        </li>


                    </ul>

                </li>



                {{-- Fullscreen --}}
                <li class="nav-item">

                    <a
                        class="nav-link"
                        href="#"
                        data-lte-toggle="fullscreen"
                    >

                        <i
                            data-lte-icon="maximize"
                            class="bi bi-arrows-fullscreen"
                        ></i>

                        <i
                            data-lte-icon="minimize"
                            class="bi bi-fullscreen-exit d-none"
                        ></i>

                    </a>

                </li>



                {{-- USER --}}
                <li
                    class="nav-item dropdown user-menu"
                >

                    <a
                        href="#"
                        class="nav-link dropdown-toggle"
                        data-bs-toggle="dropdown"
                    >


                        <span
                            class="
                                d-inline-flex
                                align-items-center
                                justify-content-center
                                rounded-circle
                                bg-primary
                                text-white
                                me-2
                            "
                            style="
                                width:32px;
                                height:32px;
                            "
                        >

                            <i
                                class="bi bi-person-fill"
                            ></i>

                        </span>


                        <span
                            class="d-none d-md-inline"
                        >

                            {{
                                auth()->user()->name
                                ?? 'Admin'
                            }}

                        </span>


                    </a>



                    <ul
                        class="
                            dropdown-menu
                            dropdown-menu-lg
                            dropdown-menu-end
                        "
                    >


                        <li
                            class="
                                user-header
                                text-bg-primary
                            "
                        >

                            <div
                                class="
                                    d-inline-flex
                                    align-items-center
                                    justify-content-center
                                    rounded-circle
                                    bg-white
                                    text-primary
                                    mb-2
                                "
                                style="
                                    width:70px;
                                    height:70px;
                                "
                            >

                                <i
                                    class="
                                        bi
                                        bi-person-fill
                                        fs-1
                                    "
                                ></i>

                            </div>


                            <p>

                                {{
                                    auth()->user()->name
                                    ?? 'Admin'
                                }}


                                <small>

                                    {{
                                        auth()->user()->email
                                        ?? ''
                                    }}

                                </small>

                            </p>

                        </li>



                        <li class="user-footer">


                            @if(Route::has('profile.edit'))

                                <a
                                    href="{{
                                        route('profile.edit')
                                    }}"
                                    class="
                                        btn
                                        btn-outline-secondary
                                    "
                                >

                                    Profile

                                </a>

                            @endif



                            @if(Route::has('logout'))

                                <form
                                    action="{{
                                        route('logout')
                                    }}"
                                    method="POST"
                                    class="float-end"
                                >

                                    @csrf


                                    <button
                                        type="submit"
                                        class="
                                            btn
                                            btn-outline-danger
                                        "
                                    >

                                        Logout

                                    </button>

                                </form>

                            @endif


                        </li>


                    </ul>

                </li>


            </ul>


        </div>

    </nav>



    {{-- =====================================================
        SIDEBAR
    ====================================================== --}}

    <aside
        class="
            app-sidebar
            bg-body-secondary
            shadow
        "
        data-bs-theme="dark"
    >


        {{-- BRAND --}}
        <div class="sidebar-brand">


            <a
                href="{{ url('/admin/dashboard') }}"
                class="
                    brand-link
                    text-decoration-none
                "
            >


                <span
                    class="
                        brand-text
                        fw-bold
                        text-uppercase
                    "
                    style="
                        letter-spacing:2px;
                    "
                >

                    BAGORA

                </span>


                <small
                    class="
                        d-block
                        text-secondary
                    "
                    style="
                        font-size:11px;
                        margin-top:-5px;
                    "
                >

                    Ecommerce Admin

                </small>


            </a>


        </div>



        <div class="sidebar-wrapper">


            <nav
                class="mt-2"
                aria-label="Bagora Admin Navigation"
            >


                <ul
                    class="
                        nav
                        sidebar-menu
                        flex-column
                    "
                    data-lte-toggle="treeview"
                    data-accordion="false"
                    id="navigation"
                >



                    {{-- ========================================
                        DASHBOARD
                    ========================================= --}}

                    <li class="nav-item">


                        <a
                            href="{{
                                url('/admin/dashboard')
                            }}"
                            class="
                                nav-link

                                {{
                                    request()->is(
                                        'admin/dashboard'
                                    )
                                    ? 'active'
                                    : ''
                                }}
                            "
                        >


                            <i
                                class="
                                    nav-icon
                                    bi
                                    bi-speedometer2
                                "
                            ></i>


                            <p>
                                Dashboard
                            </p>


                        </a>


                    </li>




                    {{-- ========================================
                        CATALOG
                    ========================================= --}}

                    <li class="nav-header">

                        CATALOG

                    </li>


                    @php

                        $catalogOpen =

                            request()->is(
                                'admin/categories*'
                            )

                            ||

                            request()->is(
                                'admin/subcategories*'
                            )

                            ||

                            request()->is(
                                'admin/childcategories*'
                            )

                            ||

                            request()->is(
                                'admin/brands*'
                            )

                            ||

                            request()->is(
                                'admin/colors*'
                            )

                            ||

                            request()->is(
                                'admin/sizes*'
                            );

                    @endphp



                    <li
                        class="
                            nav-item

                            {{
                                $catalogOpen
                                ? 'menu-open'
                                : ''
                            }}
                        "
                    >


                        <a
                            href="#"
                            class="
                                nav-link

                                {{
                                    $catalogOpen
                                    ? 'active'
                                    : ''
                                }}
                            "
                        >


                            <i
                                class="
                                    nav-icon
                                    bi
                                    bi-grid
                                "
                            ></i>


                            <p>

                                Catalog

                                <i
                                    class="
                                        nav-arrow
                                        bi
                                        bi-chevron-right
                                    "
                                ></i>

                            </p>


                        </a>



                        <ul
                            class="nav nav-treeview"
                        >


                            {{-- CATEGORY --}}
                            <li class="nav-item">


                                <a
                                    href="{{
                                        url(
                                            '/admin/categories'
                                        )
                                    }}"
                                    class="
                                        nav-link

                                        {{
                                            request()->is(
                                                'admin/categories'
                                            )

                                            ||

                                            request()->is(
                                                'admin/categories/create'
                                            )

                                            ||

                                            request()->is(
                                                'admin/categories/*/edit'
                                            )

                                            ? 'active'
                                            : ''
                                        }}
                                    "
                                >


                                    <i
                                        class="
                                            nav-icon
                                            bi
                                            bi-folder
                                        "
                                    ></i>


                                    <p>
                                        Categories
                                    </p>


                                </a>


                            </li>



                            {{-- SUB CATEGORY --}}
                            <li class="nav-item">


                                <a
                                    href="{{
                                        url(
                                            '/admin/subcategories'
                                        )
                                    }}"
                                    class="
                                        nav-link

                                        {{
                                            request()->is(
                                                'admin/subcategories'
                                            )

                                            ||

                                            request()->is(
                                                'admin/subcategories/create'
                                            )

                                            ||

                                            request()->is(
                                                'admin/subcategories/*/edit'
                                            )

                                            ? 'active'
                                            : ''
                                        }}
                                    "
                                >


                                    <i
                                        class="
                                            nav-icon
                                            bi
                                            bi-folder2-open
                                        "
                                    ></i>


                                    <p>
                                        Sub Categories
                                    </p>


                                </a>


                            </li>



                            {{-- CHILD CATEGORY --}}
                            <li class="nav-item">


                                <a
                                    href="{{
                                        url(
                                            '/admin/childcategories'
                                        )
                                    }}"
                                    class="
                                        nav-link

                                        {{
                                            request()->is(
                                                'admin/childcategories'
                                            )

                                            ||

                                            request()->is(
                                                'admin/childcategories/create'
                                            )

                                            ||

                                            request()->is(
                                                'admin/childcategories/*/edit'
                                            )

                                            ? 'active'
                                            : ''
                                        }}
                                    "
                                >


                                    <i
                                        class="
                                            nav-icon
                                            bi
                                            bi-diagram-3
                                        "
                                    ></i>


                                    <p>
                                        Child Categories
                                    </p>


                                </a>


                            </li>



                            {{-- BRAND --}}
                            <li class="nav-item">


                                <a
                                    href="{{
                                        url(
                                            '/admin/brands'
                                        )
                                    }}"
                                    class="
                                        nav-link

                                        {{
                                            request()->is(
                                                'admin/brands'
                                            )

                                            ||

                                            request()->is(
                                                'admin/brands/create'
                                            )

                                            ||

                                            request()->is(
                                                'admin/brands/*/edit'
                                            )

                                            ? 'active'
                                            : ''
                                        }}
                                    "
                                >


                                    <i
                                        class="
                                            nav-icon
                                            bi
                                            bi-award
                                        "
                                    ></i>


                                    <p>
                                        Brands
                                    </p>


                                </a>


                            </li>



                            {{-- COLOR --}}
                            <li class="nav-item">


                                <a
                                    href="{{
                                        url(
                                            '/admin/colors'
                                        )
                                    }}"
                                    class="
                                        nav-link

                                        {{
                                            request()->is(
                                                'admin/colors'
                                            )

                                            ||

                                            request()->is(
                                                'admin/colors/create'
                                            )

                                            ||

                                            request()->is(
                                                'admin/colors/*/edit'
                                            )

                                            ? 'active'
                                            : ''
                                        }}
                                    "
                                >


                                    <i
                                        class="
                                            nav-icon
                                            bi
                                            bi-palette
                                        "
                                    ></i>


                                    <p>
                                        Colors
                                    </p>


                                </a>


                            </li>



                            {{-- SIZE --}}
                            <li class="nav-item">


                                <a
                                    href="{{
                                        url(
                                            '/admin/sizes'
                                        )
                                    }}"
                                    class="
                                        nav-link

                                        {{
                                            request()->is(
                                                'admin/sizes'
                                            )

                                            ||

                                            request()->is(
                                                'admin/sizes/create'
                                            )

                                            ||

                                            request()->is(
                                                'admin/sizes/*/edit'
                                            )

                                            ? 'active'
                                            : ''
                                        }}
                                    "
                                >


                                    <i
                                        class="
                                            nav-icon
                                            bi
                                            bi-rulers
                                        "
                                    ></i>


                                    <p>
                                        Sizes
                                    </p>


                                </a>


                            </li>


                        </ul>


                    </li>




                    {{-- ========================================
                        PRODUCTS
                    ========================================= --}}

                    <li class="nav-header">

                        PRODUCTS

                    </li>


                    @php

                        $productOpen =

                            request()->is(
                                'admin/products*'
                            )

                            ||

                            request()->is(
                                'admin/variants*'
                            );

                    @endphp



                    <li
                        class="
                            nav-item

                            {{
                                $productOpen
                                ? 'menu-open'
                                : ''
                            }}
                        "
                    >


                        <a
                            href="#"
                            class="
                                nav-link

                                {{
                                    $productOpen
                                    ? 'active'
                                    : ''
                                }}
                            "
                        >


                            <i
                                class="
                                    nav-icon
                                    bi
                                    bi-bag
                                "
                            ></i>


                            <p>

                                Products

                                <i
                                    class="
                                        nav-arrow
                                        bi
                                        bi-chevron-right
                                    "
                                ></i>

                            </p>


                        </a>



                        <ul
                            class="nav nav-treeview"
                        >


                            {{-- ALL PRODUCTS --}}
                            <li class="nav-item">


                                <a
                                    href="{{
                                        url(
                                            '/admin/products'
                                        )
                                    }}"
                                    class="
                                        nav-link

                                        {{
                                            request()->is(
                                                'admin/products'
                                            )

                                            ||

                                            request()->is(
                                                'admin/products/*/edit'
                                            )

                                            ||

                                            request()->is(
                                                'admin/products/*'
                                            )

                                            &&

                                            !request()->is(
                                                'admin/products/trashed'
                                            )

                                            ? 'active'
                                            : ''
                                        }}
                                    "
                                >


                                    <i
                                        class="
                                            nav-icon
                                            bi
                                            bi-list-ul
                                        "
                                    ></i>


                                    <p>
                                        All Products
                                    </p>


                                </a>


                            </li>



                            {{-- ADD PRODUCT --}}
                            <li class="nav-item">


                                <a
                                    href="{{
                                        url(
                                            '/admin/products/create'
                                        )
                                    }}"
                                    class="
                                        nav-link

                                        {{
                                            request()->is(
                                                'admin/products/create'
                                            )
                                            ? 'active'
                                            : ''
                                        }}
                                    "
                                >


                                    <i
                                        class="
                                            nav-icon
                                            bi
                                            bi-plus-circle
                                        "
                                    ></i>


                                    <p>
                                        Add Product
                                    </p>


                                </a>


                            </li>



                            {{-- VARIANTS --}}
                            <li class="nav-item">


                                <a
                                    href="{{
                                        url(
                                            '/admin/variants'
                                        )
                                    }}"
                                    class="
                                        nav-link

                                        {{
                                            request()->is(
                                                'admin/variants'
                                            )

                                            ||

                                            request()->is(
                                                'admin/variants/create'
                                            )

                                            ||

                                            request()->is(
                                                'admin/variants/*/edit'
                                            )

                                            ? 'active'
                                            : ''
                                        }}
                                    "
                                >


                                    <i
                                        class="
                                            nav-icon
                                            bi
                                            bi-boxes
                                        "
                                    ></i>


                                    <p>
                                        Product Variants
                                    </p>


                                </a>


                            </li>


                        </ul>


                    </li>




                    {{-- ========================================
                        SALES
                    ========================================= --}}

                    <li class="nav-header">

                        SALES

                    </li>



                    {{-- ORDERS --}}
                    <li class="nav-item">


                        <a
                            href="{{
                                url(
                                    '/admin/orders'
                                )
                            }}"
                            class="
                                nav-link

                                {{
                                    request()->is(
                                        'admin/orders*'
                                    )
                                    ? 'active'
                                    : ''
                                }}
                            "
                        >


                            <i
                                class="
                                    nav-icon
                                    bi
                                    bi-cart-check
                                "
                            ></i>


                            <p>
                                Orders
                            </p>


                        </a>


                    </li>



                    {{-- CUSTOMERS --}}
                    <li class="nav-item">


                        <a
                            href="{{
                                url(
                                    '/admin/customers'
                                )
                            }}"
                            class="
                                nav-link

                                {{
                                    request()->is(
                                        'admin/customers*'
                                    )
                                    ? 'active'
                                    : ''
                                }}
                            "
                        >


                            <i
                                class="
                                    nav-icon
                                    bi
                                    bi-people
                                "
                            ></i>


                            <p>
                                Customers
                            </p>


                        </a>


                    </li>



                    {{-- ABANDONED CHECKOUT --}}
                    <li class="nav-item">


                        <a
                            href="{{
                                url(
                                    '/admin/checkout-drafts'
                                )
                            }}"
                            class="
                                nav-link

                                {{
                                    request()->is(
                                        'admin/checkout-drafts*'
                                    )
                                    ? 'active'
                                    : ''
                                }}
                            "
                        >


                            <i
                                class="
                                    nav-icon
                                    bi
                                    bi-cart-x
                                "
                            ></i>


                            <p>
                                Abandoned Checkout
                            </p>


                        </a>


                    </li>




                    {{-- ========================================
                        MARKETING
                    ========================================= --}}

                    <li class="nav-header">

                        MARKETING

                    </li>



                    <li class="nav-item">


                        <a
                            href="{{
                                url(
                                    '/admin/banners'
                                )
                            }}"
                            class="
                                nav-link

                                {{
                                    request()->is(
                                        'admin/banners*'
                                    )
                                    ? 'active'
                                    : ''
                                }}
                            "
                        >


                            <i
                                class="
                                    nav-icon
                                    bi
                                    bi-images
                                "
                            ></i>


                            <p>
                                Banners
                            </p>


                        </a>


                    </li>



                    <li class="nav-item">


                        <a
                            href="{{
                                url(
                                    '/admin/coupons'
                                )
                            }}"
                            class="
                                nav-link

                                {{
                                    request()->is(
                                        'admin/coupons*'
                                    )
                                    ? 'active'
                                    : ''
                                }}
                            "
                        >


                            <i
                                class="
                                    nav-icon
                                    bi
                                    bi-ticket-perforated
                                "
                            ></i>


                            <p>
                                Coupons
                            </p>


                        </a>


                    </li>




                    {{-- ========================================
                        SYSTEM
                    ========================================= --}}

                    <li class="nav-header">

                        SYSTEM

                    </li>


                    @php

                        $trashOpen =

                            request()->is(
                                'admin/categories/trashed'
                            )

                            ||

                            request()->is(
                                'admin/subcategories/trashed'
                            )

                            ||

                            request()->is(
                                'admin/childcategories/trashed'
                            )

                            ||

                            request()->is(
                                'admin/brands/trashed'
                            )

                            ||

                            request()->is(
                                'admin/colors/trashed'
                            )

                            ||

                            request()->is(
                                'admin/sizes/trashed'
                            )

                            ||

                            request()->is(
                                'admin/products/trashed'
                            )

                            ||

                            request()->is(
                                'admin/variants/trashed'
                            );

                    @endphp



                    {{-- TRASH --}}
                    <li
                        class="
                            nav-item

                            {{
                                $trashOpen
                                ? 'menu-open'
                                : ''
                            }}
                        "
                    >


                        <a
                            href="#"
                            class="
                                nav-link

                                {{
                                    $trashOpen
                                    ? 'active'
                                    : ''
                                }}
                            "
                        >


                            <i
                                class="
                                    nav-icon
                                    bi
                                    bi-trash
                                "
                            ></i>


                            <p>

                                Trashed

                                <i
                                    class="
                                        nav-arrow
                                        bi
                                        bi-chevron-right
                                    "
                                ></i>

                            </p>


                        </a>



                        <ul
                            class="nav nav-treeview"
                        >


                            <li class="nav-item">

                                <a
                                    href="{{
                                        url(
                                            '/admin/categories/trashed'
                                        )
                                    }}"
                                    class="
                                        nav-link

                                        {{
                                            request()->is(
                                                'admin/categories/trashed'
                                            )
                                            ? 'active'
                                            : ''
                                        }}
                                    "
                                >

                                    <i
                                        class="
                                            nav-icon
                                            bi
                                            bi-folder-x
                                        "
                                    ></i>

                                    <p>
                                        Categories
                                    </p>

                                </a>

                            </li>



                            <li class="nav-item">

                                <a
                                    href="{{
                                        url(
                                            '/admin/subcategories/trashed'
                                        )
                                    }}"
                                    class="
                                        nav-link

                                        {{
                                            request()->is(
                                                'admin/subcategories/trashed'
                                            )
                                            ? 'active'
                                            : ''
                                        }}
                                    "
                                >

                                    <i
                                        class="
                                            nav-icon
                                            bi
                                            bi-folder-x
                                        "
                                    ></i>

                                    <p>
                                        Sub Categories
                                    </p>

                                </a>

                            </li>



                            <li class="nav-item">

                                <a
                                    href="{{
                                        url(
                                            '/admin/childcategories/trashed'
                                        )
                                    }}"
                                    class="
                                        nav-link

                                        {{
                                            request()->is(
                                                'admin/childcategories/trashed'
                                            )
                                            ? 'active'
                                            : ''
                                        }}
                                    "
                                >

                                    <i
                                        class="
                                            nav-icon
                                            bi
                                            bi-folder-x
                                        "
                                    ></i>

                                    <p>
                                        Child Categories
                                    </p>

                                </a>

                            </li>



                            <li class="nav-item">

                                <a
                                    href="{{
                                        url(
                                            '/admin/brands/trashed'
                                        )
                                    }}"
                                    class="
                                        nav-link

                                        {{
                                            request()->is(
                                                'admin/brands/trashed'
                                            )
                                            ? 'active'
                                            : ''
                                        }}
                                    "
                                >

                                    <i
                                        class="
                                            nav-icon
                                            bi
                                            bi-trash
                                        "
                                    ></i>

                                    <p>
                                        Brands
                                    </p>

                                </a>

                            </li>



                            <li class="nav-item">

                                <a
                                    href="{{
                                        url(
                                            '/admin/colors/trashed'
                                        )
                                    }}"
                                    class="
                                        nav-link

                                        {{
                                            request()->is(
                                                'admin/colors/trashed'
                                            )
                                            ? 'active'
                                            : ''
                                        }}
                                    "
                                >

                                    <i
                                        class="
                                            nav-icon
                                            bi
                                            bi-trash
                                        "
                                    ></i>

                                    <p>
                                        Colors
                                    </p>

                                </a>

                            </li>



                            <li class="nav-item">

                                <a
                                    href="{{
                                        url(
                                            '/admin/sizes/trashed'
                                        )
                                    }}"
                                    class="
                                        nav-link

                                        {{
                                            request()->is(
                                                'admin/sizes/trashed'
                                            )
                                            ? 'active'
                                            : ''
                                        }}
                                    "
                                >

                                    <i
                                        class="
                                            nav-icon
                                            bi
                                            bi-trash
                                        "
                                    ></i>

                                    <p>
                                        Sizes
                                    </p>

                                </a>

                            </li>



                            <li class="nav-item">

                                <a
                                    href="{{
                                        url(
                                            '/admin/products/trashed'
                                        )
                                    }}"
                                    class="
                                        nav-link

                                        {{
                                            request()->is(
                                                'admin/products/trashed'
                                            )
                                            ? 'active'
                                            : ''
                                        }}
                                    "
                                >

                                    <i
                                        class="
                                            nav-icon
                                            bi
                                            bi-bag-x
                                        "
                                    ></i>

                                    <p>
                                        Products
                                    </p>

                                </a>

                            </li>



                            <li class="nav-item">

                                <a
                                    href="{{
                                        url(
                                            '/admin/variants/trashed'
                                        )
                                    }}"
                                    class="
                                        nav-link

                                        {{
                                            request()->is(
                                                'admin/variants/trashed'
                                            )
                                            ? 'active'
                                            : ''
                                        }}
                                    "
                                >

                                    <i
                                        class="
                                            nav-icon
                                            bi
                                            bi-trash
                                        "
                                    ></i>

                                    <p>
                                        Variants
                                    </p>

                                </a>

                            </li>


                        </ul>


                    </li>



                    {{-- SETTINGS --}}
                    <li class="nav-item">


                        <a
                            href="{{
                                url(
                                    '/admin/settings'
                                )
                            }}"
                            class="
                                nav-link

                                {{
                                    request()->is(
                                        'admin/settings*'
                                    )
                                    ? 'active'
                                    : ''
                                }}
                            "
                        >


                            <i
                                class="
                                    nav-icon
                                    bi
                                    bi-gear
                                "
                            ></i>


                            <p>
                                Settings
                            </p>


                        </a>


                    </li>



                    {{-- WEBSITE --}}
                    <li class="nav-item">


                        <a
                            href="{{ url('/') }}"
                            target="_blank"
                            class="nav-link"
                        >


                            <i
                                class="
                                    nav-icon
                                    bi
                                    bi-box-arrow-up-right
                                "
                            ></i>


                            <p>
                                Visit Website
                            </p>


                        </a>


                    </li>


                </ul>


            </nav>


        </div>


    </aside>



    {{-- =====================================================
        MAIN CONTENT
    ====================================================== --}}

    <main class="app-main">


        {{-- PAGE HEADER --}}
        @hasSection('page-header')

            <div class="app-content-header">

                <div class="container-fluid">

                    @yield('page-header')

                </div>

            </div>

        @endif



        <div class="app-content">

            <div class="container-fluid">


                {{-- SUCCESS --}}
                @if(session('success'))

                    <div
                        class="
                            alert
                            alert-success
                            alert-dismissible
                            fade
                            show
                        "
                    >

                        <i
                            class="
                                bi
                                bi-check-circle
                                me-1
                            "
                        ></i>

                        {{ session('success') }}


                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="alert"
                        ></button>

                    </div>

                @endif



                {{-- ERROR --}}
                @if(session('error'))

                    <div
                        class="
                            alert
                            alert-danger
                            alert-dismissible
                            fade
                            show
                        "
                    >

                        <i
                            class="
                                bi
                                bi-exclamation-triangle
                                me-1
                            "
                        ></i>

                        {{ session('error') }}


                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="alert"
                        ></button>

                    </div>

                @endif



                {{-- VALIDATION --}}
                @if($errors->any())

                    <div
                        class="
                            alert
                            alert-danger
                            alert-dismissible
                            fade
                            show
                        "
                    >

                        <strong>

                            Please fix the following:

                        </strong>


                        <ul class="mb-0 mt-2">

                            @foreach(
                                $errors->all()
                                as $error
                            )

                                <li>

                                    {{ $error }}

                                </li>

                            @endforeach

                        </ul>


                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="alert"
                        ></button>

                    </div>

                @endif



                {{-- ==========================
                    CHILD PAGE CONTENT
                =========================== --}}

                @yield('content')


            </div>

        </div>


    </main>



    {{-- =====================================================
        FOOTER
    ====================================================== --}}

    <footer class="app-footer">


        <div
            class="
                float-end
                d-none
                d-sm-inline
            "
        >

            Bagora Ecommerce

        </div>


        <strong>

            Copyright &copy;

            {{ date('Y') }}

            <a
                href="{{ url('/') }}"
                target="_blank"
                class="text-decoration-none"
            >

                Bagora

            </a>.

        </strong>


        All rights reserved.


    </footer>


</div>



{{-- =========================================================
    JS
========================================================= --}}


{{-- Overlay Scrollbars --}}
<script
    src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js"
></script>


{{-- Bootstrap --}}
<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
></script>


{{-- AdminLTE --}}
<script
    src="{{ asset('backend/assets/js/adminlte.js') }}"
></script>



{{-- SIDEBAR SCROLL --}}
<script>

document.addEventListener(
    'DOMContentLoaded',
    function () {

        const sidebarWrapper =
            document.querySelector(
                '.sidebar-wrapper'
            );


        const isMobile =
            window.innerWidth <= 992;


        if (

            sidebarWrapper

            &&

            window.OverlayScrollbarsGlobal

            &&

            window
                .OverlayScrollbarsGlobal
                .OverlayScrollbars

            &&

            !isMobile

        ) {

            window
                .OverlayScrollbarsGlobal
                .OverlayScrollbars(

                    sidebarWrapper,

                    {

                        scrollbars: {

                            theme:
                                'os-theme-light',

                            autoHide:
                                'leave',

                            clickScroll:
                                true

                        }

                    }

                );

        }

    }
);

</script>



{{-- THEME --}}
<script>

document.addEventListener(
    'DOMContentLoaded',
    function () {

        const buttons =
            document.querySelectorAll(
                '.bagora-theme'
            );


        function setTheme(value) {

            let theme = value;


            if (value === 'auto') {

                theme =
                    window.matchMedia(
                        '(prefers-color-scheme: dark)'
                    ).matches

                    ? 'dark'

                    : 'light';

            }


            document
                .documentElement
                .setAttribute(
                    'data-bs-theme',
                    theme
                );


            document
                .documentElement
                .style
                .colorScheme =
                theme;


            try {

                localStorage.setItem(
                    'lte-theme',
                    value
                );

            } catch (e) {}

        }


        buttons.forEach(
            function (button) {

                button.addEventListener(
                    'click',
                    function () {

                        setTheme(
                            this.dataset.theme
                        );

                    }
                );

            }
        );

    }
);

</script>


@stack('scripts')


</body>

</html>