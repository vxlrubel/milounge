@extends('layouts.app')

@section('title') My Orders @endsection

@push('style')
    <link rel="stylesheet" href="/assets/css/consumerdashboard.css"/>
@endpush
@section('content')
    <section class="consumerdashboard-section">
        <div class="container">
            <div class="consumerdashboard-content">
                <div class="row mt-3 mb-3">

                    <div class="col-md-4 col-lg-3">
                        @include('profile.component.sidebar')
                    </div>

                    <div class="col-md-8 col-lg-9">
                        <div class="accountdetails-content consumerorderdetails-content myorder-large-device"
                             style="min-height: 500px">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="profile-title profile-myordertitle">
                                        <h1><span><i class="fa-solid fa-boxes-stacked"></i></span>My Orders</h1>
                                    </div>
                                </div>
                            </div>
                            <div class="order-searchbydate-content">
                                <form @submit.prevent="getOrders()">
                                    <div class="orderlist-searchbydate">
                                        <div class="form-group searchdate-field">
                                            <label for="">From</label>
                                            <input type="date" v-model="start_date"
                                                   class="form-control searchdate-formfield" placeholder="MM/DD/YYYY">
                                        </div>
                                        <div class="form-group searchdate-field searchdate-field2">
                                            <label for="">To</label>
                                            <input type="date" v-model="end_date"
                                                   class="form-control searchdate-formfield" placeholder="MM/DD/YYYY">
                                        </div>
                                        <div class="form-group">
                                            <button class="btn datebysearchbtn" type="submit">Search</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="ad-ordershow-table" v-cloak>
                                <table class="table text-center consumer-ordertable">
                                    <thead class="ordershow-table">
                                    <tr>
                                        <th scope="col">Date</th>
                                        <th scope="col">Order ID</th>
                                        <th scope="col">Amount</th>
                                        <th scope="col">Details</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="val in orders">
                                        <td>
                                            <span class="badge bg-success">@{{ val.status }}</span> <br>
                                            <small>@{{ dateFormat(val.order_date, 'lll') }}</small>
                                        </td>
                                        <td><span class="table-orderid">@{{ val.id }}</span></td>
                                        <td>{{config('app.currency')}}@{{ (val.payable_amount).toFixed(2) }}</td>
                                        <td>
                                            <a href="#" class="orderdetailsbtn" @click.prevent="getOrder(val.id)"><span><i
                                                        class="fa-solid fa-list"></i></span>Details</a>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- For Mobile Device Design -->
                        <div class="mobileconsumerde-content myorder-mobile-device">
                            <div class="consumerorder-header">
                                <h4><span><i class="fa-solid fa-boxes-stacked"></i></span>My Orders</h4>
                            </div>
                            <div class="mobilesearchdate-content">
                                <form>
                                    <div class="searchdatefrom">
                                        <div class="mobiledatesearch-from">
                                            <div class="form-group">
                                                <label for="">From</label>
                                                <input type="date" v-model="start_date"
                                                       class="form-control mobiledatesearch-forminput"
                                                       placeholder="DD/MM/YYYY">
                                            </div>
                                        </div>
                                        <div class="mobiledatesearch-to">
                                            <div class="form-group">
                                                <label for="">To</label>
                                                <input type="date" v-model="end_date"
                                                       class="form-control mobiledatesearch-forminput"
                                                       placeholder="DD/MM/YYYY">
                                            </div>
                                        </div>
                                        <div class="mobiledatesearch-button">
                                            <button type="button" class="btn mobiledatebysearchbtn"
                                                    @click="getOrders()">Search
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="mobileconsumerorder-tabledata" v-cloak>
                                <div class="mobileorderdatalist-content" v-for="val in orders">
                                    <div class="mobileodl">
                                        <div class="mo-content">
                                            <div class="mobileorder-date">
                                                <h5>Date: @{{ dateFormat(val.order_date, 'lll') }}</h5>
                                                <h6><span>Order No:</span> #@{{ val.id }}</h6>
                                            </div>
                                            <div class="mobileodl-details-button">
                                                <a @click.prevent="getOrder(val.id)"><i
                                                        class="fa-solid fa-list"></i></a>
                                            </div>
                                        </div>
                                        <div class="mobileorder-details">
                                            <div class="leftstright-line"></div>
                                            <div class="mobileorder-no-type">
                                                <p><span class="mo-no-type-lable">Status:</span> <span
                                                        class="badge text-bg-success">@{{ val.status }}</span></p>
                                            </div>
                                            <div class="leftstright-line leftstright-line1"></div>
                                            <div class="mobileorder-no-type">
                                                <p class="mobileorder-price"><span
                                                        class="mo-no-type-lable">Price:</span> {{config('app.currency')}}
                                                    @{{ (val.net_amount).toFixed(2) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="detailsModal" tabindex="-1" aria-labelledby="detailsModal" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content" v-if="order">
                        <div class="modal-header">
                            <h1 class="modal-title profileimage-popuptitle" id="profileImage-popup">Order #@{{
                                order.id }}</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12 col-lg-12 m-auto">
                                    <div class="modalorder-detailscontenthold">
                                        <div class="modalorder-date-status">
                                            <div class="modalorder-date">
                                                <h5>Ordered Date</h5>
                                                <p>@{{ dateFormat(order.order_date, 'lll') }}</p>
                                            </div>
                                            <div class="modalorder-status">
                                                <h5>Order status</h5>
                                                <p>@{{ order.status }}</p>
                                            </div>

                                            <div class="modalorder-status">
                                                <h5>Order type</h5>
                                                <p>@{{ order.order_type }}</p>
                                            </div>
                                        </div>
                                        <table class="table modalordered-detailstable">
                                            <thead>
                                            <!-- <tr>
                                                <th colspan="2">
                                                    <h5>Order summery (@{{ order.status }})</h5>
                                                </th>
                                            </tr> -->
                                            <tr>
                                                <th class="modaltable-customwidthImg">Image</th>
                                                <th class="modaltable-customwidthItem">Item</th>
                                                <th class="modaltable-customwidthAmount">Amount</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="item in order.order_products">
                                                <td v-if="item.product?.type === 'ITEM'">
                                                    <div class="modalorder-image">
                                                        <img v-if="item.product?.files.length" style="width: 55px"
                                                             :src="'{{config('api.apiUrl')}}/products/image/'+ item.product?.files[0].file_name"
                                                             alt="">
                                                    </div>
                                                </td>
                                                <td v-if="item.product?.type === 'ITEM'">
                                                    <strong>@{{ item.unit }} x @{{ item.product?.short_name }}</strong>
                                                    <br>
                                                    <div>
                                                        <ul class="modalorder-tablelist">
                                                            <li v-for="component in item.components">
                                                                <span v-if="!['None', 'Normal'].includes(component.product?.short_name)">- @{{ component.product?.short_name }}</span>

                                                                <ul>
                                                                    <li v-for="sub in component?.components">
                                                                        <span> > @{{ sub.product?.short_name }}</span>
                                                                    </li>
                                                                </ul>

                                                            </li>

                                                        </ul>
                                                    </div>
                                                </td>
                                                <td v-if="item.product?.type === 'ITEM'" class="ordertable-price">
                                                    {{config('app.currency')}}@{{ (item.net_amount).toFixed(2) }}
                                                </td>

                                            </tr>
                                            <tr class="modalorder-subtotalbg">
                                                <th></th>
                                                <th class="text-end">Sub total:</th>
                                                <th>{{config('app.currency')}}@{{ (order.net_amount || 0).toFixed(2) }}</th>
                                            </tr>
                                            <tr class="modalorder-subtotalbg">
                                                <th></th>
                                                <td class="text-end">Delivery Charge:</td>
                                                <td>{{config('app.currency')}}@{{ (order.delivery_charge || 0).toFixed(2) }}</td>
                                            </tr>
                                            <tr class="modalorder-subtotalbg">
                                                <th></th>
                                                <td class="text-end">Discount:</td>
                                                <td>{{config('app.currency')}}@{{ (order.discounted_amount || 0).toFixed(2) }}</td>
                                            </tr>
                                            <tr class="modalorder-subtotalbg">
                                                <th></th>
                                                <th class="text-end">Total payable:</th>
                                                <th>{{config('app.currency')}}@{{ (order.payable_amount || 0).toFixed(2) }}</th>
                                            </tr>

                                            </tbody>
                                        </table>
                                        <div class="mo-upload-invoice-button">
                                            {{--                                            <div class="mo-upload-button">--}}
                                            {{--                                                <a href="#" data-bs-target="#fileUploadModal" class="mo-uploadbtn"--}}
                                            {{--                                                   data-bs-toggle="modal"><i--}}
                                            {{--                                                        class="fa fa-upload"></i>Upload files</a>--}}
                                            {{--                                            </div>--}}
                                            <div class="orderdetailsbtn modalorderdetails-button">
                                                <a href="javascript:void(0)" class="modalorderdetailsbtn"
                                                   @click="sendAgain(order.id)"><i
                                                        class="fa fa-arrow-circle-right"></i>Send invoice</a>
                                            </div>
                                            <div class="orderdetailsbtn modalorderdetails-button2 ms-2">
                                                <a type="button" class="modalorderdetailsbtn" data-bs-dismiss="modal"
                                                   aria-label="Close">
                                                    Okay
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="modal-footer">
                            <button type="button" class="btn pass-editbtn modalorder-okaybtn" data-bs-dismiss="modal"
                                    aria-label="Close">
                                Okay
                            </button>
                        </div> -->
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection

@push('script')
    <script>
        const {createApp} = Vue

        createApp({
            data() {
                return {
                    api_url: '{{config('api.apiUrl')}}',
                    headers: {
                        "Authorization": "Bearer {{session('api_token')}}"
                    },
                    file_headers: {
                        Authorization: "Bearer " + '{{session('api_token')}}',
                        "Access-Control-Allow-Origin": "*",
                        "X-Requested-With": "XMLHttpRequest",
                        'Content-Type': "multipart/form-data",
                    },


                    user_id: '{{session('user')->id ?? null}}',

                    order: null,
                    orders: [],

                    start_date: moment().startOf('month').format('YYYY-MM-DD'),
                    end_date: moment().format('YYYY-MM-DD'),

                    comments: [],
                    comment: '',
                    file: null

                }
            },
            created() {
                axios.defaults.headers.common['X-CSRF-TOKEN'] = $('meta[name="csrf-token"]').attr('content');

                const self = this;
                self.getOrders();
            },
            methods: {
                dateFormat: function (date, format) {
                    return moment(date).format(format);
                },
                getOrders: function () {
                    var self = this;

                    var start_date = self.start_date + ' 00:00:00'
                    var end_date = self.end_date + ' 23:59:00'
                    axios.get(self.api_url + '/order', {
                        headers: self.headers,
                        params: {
                            start_date: start_date,
                            end_date: end_date,
                        }
                    })
                        .then(res => {
                            self.orders = res.data;
                        })
                },

                getOrder: function (id) {
                    var self = this;
                    self.order = null;

                    axios.get(self.api_url + '/order/' + id, {
                        headers: self.headers
                    })
                        .then(res => {
                            self.order = res.data;

                            if(self.order) {
                                var total_per_item_price = 0;
                                var total_per_item_component_price = 0;
                                self.order.order_products.forEach(function (op) {

                                    op.components.forEach(function (opc) {
                                        total_per_item_component_price += opc.net_amount ?? 0;
                                    })
                                    total_per_item_price += op.net_amount ?? 0;

                                    op.net_amount = total_per_item_price + total_per_item_component_price
                                })

                            }

                            $("#detailsModal").modal('show')
                        })
                },

                sendAgain: function (id) {
                    var self = this;

                    axios.post(self.api_url + '/order/send-email', {
                        order_id: id
                    }, {
                        headers: self.headers
                    })
                        .then(res => {
                            swal("Success! Email has been sent again!", {
                                icon: "success",
                            });
                            $("#detailsModal").modal('hide')
                        }).catch(err => {
                            swal("Warning! " + err.response.data.message, {
                                icon: "",
                            });

                        $("#detailsModal").modal('hide')
                    })
                },

                uploadFiles: function () {
                    const self = this;

                    var files = document.getElementById('files').files;

                    if (!files.length) {
                        swal("Warning! Please add amount.", {
                            icon: "error",
                        });
                        return false;
                    }

                    let formData = new FormData();
                    for (let i = 0; i < files.length; i++) {
                        formData.append('files[]', files[i])
                    }

                    self.loading = true;
                    const config = {
                        headers: self.headers
                    };

                    axios.post(self.api_url + '/order/upload-file/' + self.order.id, formData, config)
                        .then(res => {
                            swal("Success! Item has been added!", {
                                icon: "success",
                            });
                        })
                        .catch((err) => {
                            const msg = err.response.data.message;
                            swal({
                                title: "Warning!",
                                text: msg,
                                type: "error"
                            })
                        })
                },

                openCommentModal: function (order) {
                    var self = this;
                    self.comments = [];

                    self.order = order;
                    self.getOrderComments()
                    $("#commentModal").modal('show')

                },
                getOrderComments: function () {
                    var self = this;

                    axios.get(self.api_url + '/order-comment/' + self.order.id, {
                        headers: self.headers,
                    })
                        .then(res => {
                            self.comments = res.data;

                            self.scrollToBottom()
                        })
                },

                sendOrderComment: function () {
                    var self = this;

                    var formData = new FormData();
                    formData.append('order_id', self.order.id);
                    formData.append('comment', self.comment);
                    formData.append('file', self.file);

                    axios.post(self.api_url + '/order-comment', formData, {
                        headers: self.file_headers,
                    })
                        .then(res => {
                            swal("Success! Message has been sent!", {
                                icon: "success",
                            });

                            self.comments.push({
                                comment: self.comment,
                                file: self.file?.name || null,
                                user: {
                                    name: '{{session('user')->name ?? null}}'
                                },
                                user_id: '{{session('user')->id ?? null}}'
                            })

                            self.comment = ''
                        })
                        .catch(err => {
                            console.log(err.response)
                            swal("Warning! Message cannot sent! Please contact admin", {
                                icon: "warning",
                            });
                        })
                },
                onChangeOrderCommentFile: function () {
                    var self = this;
                    self.file = self.$refs.file.files[0]
                },

                downloadFile: function (file_name) {
                    const self = this;
                    axios.get(self.api_url + '/user/file/download/' + file_name, {
                        responseType: 'blob',
                        headers: self.headers
                    })
                        .then(response => {
                            const type = response.headers['content-type'];
                            const blob = new Blob([response.data], {type: type, encoding: 'UTF-8'});
                            const link = document.createElement('a');
                            link.href = window.URL.createObjectURL(blob);
                            link.download = file_name;
                            link.click();
                        })
                        .catch(err => {
                            console.log(err?.response?.data?.message)
                            swal("Warning", "File not found!");
                        })
                },
                scrollToBottom: function () {
                    setTimeout(function () {
                        $(".comment-boxfullcontent").animate({
                            scrollTop: $('.comment-boxfullcontent')[0].scrollHeight - $('.comment-boxfullcontent')[0].clientHeight
                        }, 700);
                    }, 100)
                },

                removeInputFieldFile: function () {
                    document.getElementById('orderCommentFile').value = "";
                }

            }
        }).mount('#app')

    </script>
@endpush
