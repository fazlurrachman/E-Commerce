@extends('layouts.app')

@section('title')
    Store Detail Page
@endsection
@push('addon-style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush
@section('content')
    <!-- Page Content -->
    <div class="page-content page-details" id="gallery">
        <section class="store-breadcrumbs" data-aos="fade-down" data-aos-delay="100">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <nav>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item">
                                    <a href="/index.html">Home</a>
                                </li>
                                <li class="breadcrumb-item active">
                                    Product Details
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </section>

        <section class="store-gallery mb-3">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8" data-aos="zoom-in">
                        <transition name="slide-fade" mode="out-in">
                            <img :src="photos[activePhoto].url" :key="photos[activePhoto].id" class="w-100 main-image"
                                alt="" />
                        </transition>
                    </div>
                    <div class="col-lg-2">
                        <div class="row">
                            <div class="col-3 col-lg-12 mt-2 mt-lg-0" v-for="(photo, index) in photos"
                                :key="photo.id" data-aos="zoom-in" data-aos-delay="100">
                                <a href="#" @click="changeActive(index)">
                                    <img :src="photo.url" class="w-100 thumbnail-image"
                                        :class="{ active: index == activePhoto }" alt="" />
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="store-details-container" data-aos="fade-up">
            <section class="store-heading">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-8">
                            <h1>{{ $product->name }}</h1>
                            {{-- <div class="owner">By Eva Bhoi</div> --}}
                            <div class="price">Rp.{{ number_format($product->price) }}</div>
                        </div>
                        <div class="col-lg-4 button-cart" data-aos="zoom-in">

                            {{-- Jika user login add to cart --}}
                            @auth
                                <form action="{{ route('detail-add', $product->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="d-flex">
                                        <div class="d-flex my-2">
                                            <button type="button" @click="GetMin()" class="btn btn-sm btn-danger"><i
                                                    class="fa fa-minus" aria-hidden="true"></i></button>
                                            <input type="number" name="quantity" class="form-control mx-2" readonly
                                                min="1" max="{{ $product->quantity }}" v-model="quantity"
                                                style="width: 70px !important;" />
                                            <button type="button" @click="GetPlush()" class="btn btn-sm btn-primary"><i
                                                    class="fa fa-plus" aria-hidden="true"></i></button>

                                        </div>
                                        <div class="stock_total ml-3">
                                            <div class="mt-3">
                                                <h5>Stok Total : {{ $product->quantity }}</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-success px-4 text-white btn-block my-3"
                                        {{ $product->quantity <= 0 ? 'disabled' : '' }}
                                        {{ $product->quantity == 0 ? 'disabled' : '' }}>
                                        Add to Cart
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-success px-4 text-white btn-block mb-3">
                                    Sign in to Add
                                </a>
                            @endauth

                        </div>
                    </div>
                </div>
            </section>

            <section class="store-description">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-lg-8">
                            {!! $product->description !!}
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection

@push('addon-script')
    {{-- <script src="/vendor/vue/vue.js"></script> --}}
    <script src="{{ asset('vendor/vue/vue.js') }}"></script>

    <script>
        var gallery = new Vue({
            el: "#gallery",
            mounted() {
                AOS.init();
            },
            data: {
                activePhoto: 0,
                quantity: 1,
                photos: [
                    @foreach ($product->galleries as $gallery)
                        {
                            id: {{ $gallery->id }},
                            url: "{{ url('storage/' . $gallery->photos) }}",
                        },
                    @endforeach
                ],
            },
            methods: {
                changeActive(id) {
                    this.activePhoto = id;
                },
                GetMin() {
                    if (this.quantity > 1) {
                        this.quantity--;
                    }
                },

                GetPlush() {
                    if (this.quantity < {{ $product->quantity }}) {
                        this.quantity++;
                    }
                    // this.quantity += 1;
                }
            },
        });
    </script>
@endpush
