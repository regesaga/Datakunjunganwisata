<script>

    // function slider_carousel3Init() {
    //     $('.owl-carousel3.slider_carousel3').owlCarousel({
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
    //                 items: 3
    //             }
    //         }
    //     });
    // }
    // slider_carousel3Init();

    function slider_carousel2Init() {
        $('.owl-carousel2.slider_carousel2').owlCarousel({
            dots: false,
            loop: true,
            margin: 30,
            stagePadding: 2,
            autoplay: true,
            nav: false,
            navText: ["<", ">"],
            autoplayTimeout: 1500,
            autoplayHoverPause: true,
            responsive: {
                0: {
                    items: 1
                },
                768: {
                    items: 2,
                },
                992: {
                    items: 5
                }
            }
        });
    }
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
    $('.media').owlCarousel({
        loop: true,
        margin: 10,
        animateOut: 'slideOutDown',
        animateIn: 'flipInX',
        autoplay: true,
        dots: false,
        autoplayTimeout: 7000,
        autoplayHoverPause: false,
        nav: true,
        navText: ["<div class='nav-button owl-prev'>‹</div>", "<div class='nav-button owl-next'>›</div>"],
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 2
            },
            1000: {
                items: 3
            }
        }
    });
    jQuery('.cardarticle-slider').slick({
        slidesToShow: 3,
        autoplay: true,
        loop: true,
        slidesToScroll: 1,
        autoplayHoverPause: true,
        dots: false,
        responsive: [{
                breakpoint: 768,
                settings: {
                    slidesToShow: 2
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 1
                }
            }
        ]
    });

    jQuery('.cardkuliner-slider').slick({
        slidesToShow: 3,
        autoplay: true,
        loop: true,
        slidesToScroll: 1,
        autoplayHoverPause: true,
        dots: false,
        responsive: [{
                breakpoint: 768,
                settings: {
                    slidesToShow: 2
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 1
                }
            }
        ]
    });

    jQuery('.cardakomodasi-slider').slick({
        slidesToShow: 3,
        autoplay: true,
        loop: true,
        slidesToScroll: 1,
        autoplayHoverPause: true,
        dots: false,
        responsive: [{
                breakpoint: 768,
                settings: {
                    slidesToShow: 2
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 1
                }
            }
        ]
    });
    
    function getData(location) {
        return fetch("https://data.bmkg.go.id/DataMKG/MEWS/DigitalForecast/DigitalForecast-JawaBarat.xml")
            // return fetch("https://data.bmkg.go.id/DataMKG/MEWS/DigitalForecast/DigitalForecast-JawaBarat.xml")
            .then(response => response.text())
            .then(str => (new window.DOMParser()).parseFromString(str, "text/xml"))
            .then(data => {
                var timeArray = [];
                var temArray = [];
                var humArray = [];
                var winddirArray = [];
                var windspeedArray = [];
                var weatherArray = [];

                pathTem =
                    `data/forecast/area[@description="${location}"]/parameter[@id="t"]/timerange/value[@unit="C"]`;
                pathHum = `data/forecast/area[@description="${location}"]/parameter[@id="hu"]/timerange/value`;
                pathWeather =
                    `data/forecast/area[@description="${location}"]/parameter[@id="weather"]/timerange/value`;
                pathTime = `data/forecast/area[@description="${location}"]/parameter[@id="hu"]/timerange`;
                pathWD =
                    `data/forecast/area[@description="${location}"]/parameter[@id="wd"]/timerange/value[@unit="deg"]`;
                pathWS =
                    `data/forecast/area[@description="${location}"]/parameter[@id="ws"]/timerange/value[@unit="MS"]`;

                if (data.evaluate) {
                    i = 0;
                    var nodeT = data.evaluate(pathTem, data, null, XPathResult.ANY_TYPE, null);
                    var nodeH = data.evaluate(pathHum, data, null, XPathResult.ANY_TYPE, null);
                    var nodeWD = data.evaluate(pathWD, data, null, XPathResult.ANY_TYPE, null);
                    var nodeWS = data.evaluate(pathWS, data, null, XPathResult.ANY_TYPE, null);
                    var nodeW = data.evaluate(pathWeather, data, null, XPathResult.ANY_TYPE, null);
                    var nodeTime = data.evaluate(pathTime, data, null, XPathResult.ANY_TYPE, null);
                    var resultT = nodeT.iterateNext();
                    var resultH = nodeH.iterateNext();
                    var resultWD = nodeWD.iterateNext();
                    var resultWS = nodeWS.iterateNext();
                    var resultW = nodeW.iterateNext();
                    var resultTime = nodeTime.iterateNext();

                    while (resultT && resultH && resultWD && resultWS && resultW && resultTime) {
                        timeArray[i] = resultTime.getAttributeNode("datetime").nodeValue;
                        temArray[i] = resultT.childNodes[0].nodeValue;
                        humArray[i] = resultH.childNodes[0].nodeValue;
                        winddirArray[i] = resultWD.childNodes[0].nodeValue;
                        windspeedArray[i] = Math.floor(resultWS.childNodes[0].nodeValue);
                        weatherArray[i] = resultW.childNodes[0].nodeValue;

                        resultT = nodeT.iterateNext();
                        resultH = nodeH.iterateNext();
                        resultWD = nodeWD.iterateNext();
                        resultWS = nodeWS.iterateNext();
                        resultW = nodeW.iterateNext();
                        resultTime = nodeTime.iterateNext();
                        i++;
                    }
                }

                var days = "";
                var dataHours = "";
                var dates = [];
                var months = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus",
                    "September", "Oktober", "November", "Desember"
                ];

                for (var i = 0; i < timeArray.length; i++) {
                    var date = timeArray[i][6].toString() + timeArray[i][7].toString();
                    var month = parseInt(timeArray[i][4] + timeArray[i][5]) - 1;
                    var year = timeArray[i][0].toString() + timeArray[i][1].toString() + timeArray[i][2]
                        .toString() + timeArray[i][3].toString();
                    var hour = timeArray[i][8].toString() + timeArray[i][9].toString();

                    dates[i] = date;

                    dataHours += `
                    <div class="cuaca-box">
                        <h3>${hour}.00 WIB</h3>
                        <img src="{{ asset('icon/cuaca_icons/w_${parseInt(weatherArray[i])}.png') }}" width="85px">
                        <br>
                        <i class="fas fa-temperature-high"></i> ${temArray[i]}<sup>C</sup>
                        <br>
                        <i class="fas fa-tint"></i>  ${humArray[i]}%
                        <br>
                        <i class="fas fa-location-arrow"></i> ${winddirArray[i]}<sup>o</sup>
                        <br>
                        <i class="fas fa-wind"></i> ${windspeedArray[i]} m/s
                        <br>
                    </div>
                `;
                    if (dates[i - 1] != dates[i]) {
                        days += `
                        <div class="cuaca-box">
                          <h3>${timeArray[i][6]}${timeArray[i][7]} ${months[month]} ${year}</h3>
                        </div>
                    `
                    }

                    document.getElementById(`days${location}`).innerHTML = days;
                    document.getElementById(`dataHours${location}`).innerHTML = dataHours;
                }
            })
    }

    function weatherPanel(locations) {
        body = "";
        for (i = 0; i < locations.length; i++) {
            body += `
            <div class="cuaca-container">
                <div class="cuaca-box">
                    <h1>${locations[i]}</h1>
                </div>
            </div>
            <div class"row">
            <div class="cuaca-container" id="days${locations[i]}"></div>
            <div class="cuaca-container" id="dataHours${locations[i]}"></div>
            </div>
            <hr>
            <br>
            <br>
        `;
        }

        document.getElementById("cuaca-main").innerHTML = body;
        for (i = 0; i < locations.length; i++) {
            getData(locations[i])
        }
    }

    // weatherPanel(["Cikarang", "Bekasi", "Cibinong"])
    weatherPanel(["Kuningan"])

    jQuery('.cardwisata-slider').slick({
  slidesToShow:5,
  loop: true,
  autoplay: true,
  slidesToScroll:1,
  dots: false,
  responsive:[
    {
      breakpoint: 768,
      settings: {
        slidesToShow: 2
      }
    },
    {
      breakpoint: 600,
      settings: {
        slidesToShow: 1
      }
    }
  ]
});

let cardwisatas = document.querySelectorAll('.cardwisata');
let cardwisata;
let modalcard = document.querySelector('.modalcard');
let closeButton = document.querySelector('.modalcard__close-button');
let page = document.querySelector('.page');
const cardwisataBorderRadius = 20;
const openingDuration = 600; //ms
const closingDuration = 600; //ms
const timingFunction = 'cubic-bezier(.76,.01,.65,1.38)';

var Scrollbar = window.Scrollbar;
Scrollbar.init(document.querySelector('.modalcard__scroll-area'));


function flipAnimation(first, last, options) {
  let firstRect = first.getBoundingClientRect();
  let lastRect = last.getBoundingClientRect();
  
  let deltas = {
    top: firstRect.top - lastRect.top,
    left: firstRect.left - lastRect.left,
    width: firstRect.width / lastRect.width,
    height: firstRect.height / lastRect.height
  };
  
  return last.animate([{
    transformOrigin: 'top left',
    borderRadius:`
    ${cardwisataBorderRadius/deltas.width}px / ${cardwisataBorderRadius/deltas.height}px`,
    transform: `
      translate(${deltas.left}px, ${deltas.top}px) 
      scale(${deltas.width}, ${deltas.height})
    `
  },{
    transformOrigin: 'top left',
    transform: 'none',
    borderRadius: `${cardwisataBorderRadius}px`
  }],options);
}

cardwisatas.forEach((item)=>{
  item.addEventListener('click',(e)=>{
    jQuery('.cardwisata-slider').slick('slickPause');
    cardwisata = e.currentTarget;
    page.dataset.modalcardState = 'opening';
    cardwisata.classList.add('cardwisata--opened');
    cardwisata.style.opacity = 0;
    document.querySelector('body').classList.add('no-scroll');

    let animation = flipAnimation(cardwisata,modalcard,{
      duration: openingDuration,
      easing: timingFunction,
      fill:'both'
    });

    animation.onfinish = ()=>{
      page.dataset.modalcardState = 'open';
      animation.cancel();
    };
  });
});

closeButton.addEventListener('click',(e)=>{
  page.dataset.modalcardState = 'closing';
  document.querySelector('body').classList.remove('no-scroll');
  
  let animation = flipAnimation(cardwisata,modalcard,{
    duration: closingDuration,
    easing: timingFunction,
    direction: 'reverse',
    fill:'both'
  });

  animation.onfinish = ()=>{
    page.dataset.modalcardState = 'closed';
    cardwisata.style.opacity = 1;
    cardwisata.classList.remove('cardwisata--opened');
    jQuery('.cardwisata-slider').slick('slickPlay');
    animation.cancel();
  };
});
</script>
