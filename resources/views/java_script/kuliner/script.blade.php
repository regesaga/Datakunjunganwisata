<script>
    // function slider_carousel3Init() {
    //     $('.owl-carousel3.slider_carousel3').owlCarousel({
    //         dots: false,
    //         loop: true,
    //         margin: 30,
    //         stagePadding: 2,
    //         autoplay: false,
    //         nav: false,
    //         navText: ["<", ">"],
    //         autoplayTimeout: 1500,
    //         autoplayHoverPause: true,
    //         responsive: {
    //             0: {
    //                 items: 1
    //             },
    //             768: {
    //                 items: 2,
    //             },
    //             992: {
    //                 items: 3
    //             }
    //         }
    //     });
    // }
    // slider_carousel3Init();

    // function slider_carousel2Init() {
    //     $('.owl-carousel2.slider_carousel2').owlCarousel({
    //         dots: false,
    //         loop: true,
    //         margin: 30,
    //         stagePadding: 2,
    //         autoplay: true,
    //         nav: false,
    //         navText: ["<", ">"],
    //         autoplayTimeout: 1500,
    //         autoplayHoverPause: true,
    //         responsive: {
    //             0: {
    //                 items: 1
    //             },
    //             768: {
    //                 items: 2,
    //             },
    //             992: {
    //                 items: 5
    //             }
    //         }
    //     });
    // }
    // slider_carousel2Init();

    // function slider_carousel4Init() {
    //     $('.owl-carousel4.slider_carousel4').owlCarousel({
    //         dots: false,
    //         loop: true,
    //         stagePadding: 1,
    //         autoplay: true,
    //         autoplayTimeout: 1500,
    //         autoplayHoverPause: false,
    //         responsive: {
    //             0: {
    //                 items: 1
    //             },
    //             768: {
    //                 items: 2,
    //             },
    //             992: {
    //                 items: 3
    //             }
    //         }
    //     });
    // }

    // slider_carousel4Init();
    // $('.media').owlCarousel({
    //     loop: true,
    //     margin: 10,
    //     animateOut: 'slideOutDown',
    //     animateIn: 'flipInX',
    //     autoplay: true,
    //     dots: false,
    //     autoplayTimeout: 7000,
    //     autoplayHoverPause: false,
    //     nav: true,
    //     navText: ["<div class='nav-button owl-prev'>‹</div>", "<div class='nav-button owl-next'>›</div>"],
    //     responsive: {
    //         0: {
    //             items: 1
    //         },
    //         600: {
    //             items: 2
    //         },
    //         1000: {
    //             items: 3
    //         }
    //     }
    // });
    // jQuery('.cardarticle-slider').slick({
    //     slidesToShow: 3,
    //     autoplay: true,
    //     slidesToScroll: 1,
    //     dots: false,
    //     responsive: [{
    //             breakpoint: 768,
    //             settings: {
    //                 slidesToShow: 2
    //             }
    //         },
    //         {
    //             breakpoint: 600,
    //             settings: {
    //                 slidesToShow: 1
    //             }
    //         }
    //     ]
    // });



    // Panggil loadData saat halaman dimuat
    // $(document).ready(function() {
    //     loadData();
    // });

    // function loadData() {
    //     $.ajax({
    //         url: "{{ route('website.ajax.kuliner') }}",
    //         data: {
    //             category: $('select[name="category"]').val(),
    //             vendor: $('input[name="vendor"]').val(),
    //         },
    //         type: 'GET',
    //         dataType: 'json',
    //         success: function(response) {
    //             console.log(response);
    //             // Kosongkan container sebelum menambahkan data baru
    //             $('#publishContainer').empty();
                
    //             // Loop through each data in the response
    //             response.data.forEach(function(dt_publish) {
    //                 var cardHtml = `
    //         <article class="entry event col-md-6 col-lg-4 mb-0 d-flex align-items-stretch">
    //             <div class="grid-inner bg-white row g-0 p-2 border-0 rounded-5 shadow-sm h-shadow all-ts h-translate-y-sm">
    //                 <div class="col-12 mb-md-0">
    //                     <div class="entry-image mb-2">
    //                         <img src="${dt_publish.thumbnail}" alt="Inventore voluptates velit totam ipsa tenetur" class="rounded-5">
    //                         <div class="bg-overlay">
    //                             <div class="bg-overlay-content justify-content-start align-items-start">
    //                                 <div class="badge bg-light text-dark rounded-pill">${dt_publish.location}</div>
    //                             </div>
    //                         </div>
    //                     </div>
    //                 </div>
    //                 <div class="col-12 p-4 pt-0 pb-1">
    //                     <div class="entry-title nott">
    //                         <h3>${dt_publish.namakuliner}</h3>
    //                     </div>
    //                     <div class="entry-meta no-separator mb-3">
    //                         <ul>
    //                             <li class="fw-normal"><i class="uil text-warning uil-map-marker"></i> ${dt_publish.locationDetail}</li>
    //                             <li><a class="text-warning" href="${dt_publish.mapsLink}">Lihat Maps</a></li>
    //                         </ul>
    //                     </div>
    //                     <div class="mb-3">
    //                         <div class="fw-bold">${dt_publish.description}</div>
    //                     </div>
    //                     <div class="entry-meta no-separator mb-3">
    //                         <ul>
    //                             <li class="fw-normal text-warning"><i class="uil bi-telephone-fill"></i> ${dt_publish.telpon}</li>
    //                         </ul>
    //                     </div>
    //                     <div class="entry-meta no-separator mb-3">
    //                         <ul>
    //                             <li><a href="${dt_publish.discCardLink}" class="fw-normal text-dark"><i class="uil uil-ticket text-warning"></i> Disc. Card</a></li>
    //                         </ul>
    //                     </div>
    //                 </div>
    //             </div>
    //         </article>
    //     `;
    //                 $('#publishContainer').append(cardHtml);
    //             });
    //             var paginationHtml = `
    //         <nav>
    //             <ul class="pagination pagination-rounded pagination-3d pagination-md">
    //                 <li class="page-item"><a class="page-link" href="${response.first_page_url}">First</a></li>
    //                 <li class="page-item"><a class="page-link" href="${response.prev_page_url}">Previous</a></li>
    //                 <li class="page-item"><a class="page-link" href="${response.next_page_url}">Next</a></li>
    //                 <li class="page-item"><a class="page-link" href="${response.last_page_url}">Last</a></li>
    //             </ul>
    //         </nav>
    //     `;
    //     $('#publishContainer').append(paginationHtml);
    //         },

    //     });
        
    // }


    // // Tambahkan event listener untuk input pencarian
    // $('select[name="category"], input[name="keyboard"]').on('input', function() {
    //     loadData(); // Panggil kembali loadData saat input berubah
    // });
</script>
