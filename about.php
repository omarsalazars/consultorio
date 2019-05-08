<!doctype html>
<html lang="en">

    <head>
        <?php require 'view/assets.php' ?>
    </head>

    <body>
        <?php require 'view/header.php' ?>
        <!--================ Banner Area =================-->
        <section class="banner_area">
            <div class="banner_inner d-flex align-items-center">
                <div class="container">
                    <div class="banner_content text-left">
                        <h2>About Us</h2>
                        <div class="page_link">
                            <a href="index.html">Home</a>
                            <a href="about.html">About</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--================End Banner Area =================-->

        <!-- Start Appointment Area -->
        <section class="appointment-area">
            <div class="container">
                <div class="row justify-content-between align-items-center appointment-wrap">
                    <div class="col-lg-5 col-md-6 appointment-left">
                        <h1>
                            Servicing Hours
                        </h1>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                        </p>
                        <ul class="time-list">
                            <li class="d-flex justify-content-between">
                                <span>Monday-Friday</span>
                                <span>08.00 am - 10.00 pm</span>
                            </li>
                            <li class="d-flex justify-content-between">
                                <span>Saturday</span>
                                <span>08.00 am - 10.00 pm</span>
                            </li>
                            <li class="d-flex justify-content-between">
                                <span>Sunday</span>
                                <span>08.00 am - 10.00 pm</span>
                            </li>
                        </ul>
                    </div>
                    <div class="col-lg-6 col-md-6 pt-60 pb-60">
                        <div class="appointment-right">
                            <form class="form-wrap" action="#">
                                <h3 class="pb-20 text-center mb-20">Book an Appointment</h3>
                                <input id="nombre" type="text" class="form-control" name="name" placeholder="Patient Name" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Patient Name'">
                                <input id="telefono" type="text" class="form-control" name="phone" placeholder="Phone " onfocus="this.placeholder = ''" onblur="this.placeholder = 'Phone'">
                                <input id="email" type="email" class="form-control" name="email" placeholder="Email Address" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Email Address'">
                                <input id="nacimiento" name="dop" class="dates form-control" placeholder="Date of Birth" type="date">
                                <div class="form-select" id="service-select">
                                    <select id="hora">
                                        <option data-display="">Horario</option>
                                        <option value="10:00">10:00</option>
                                        <option value="11:00">11:00</option>
                                        <option value="12:00">12:00</option>
                                        <option value="13:00">13:00</option>
                                    </select>
                                </div>
                                <input id="fecha" class="dates form-control" placeholder="appointment Date" type="date">
                                <textarea id="mensaje" name="messege" class="" rows="5" placeholder="Messege" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Messege'"></textarea>
                                <div class="text-center">
                                    <button type="button" id="submit" class="main_btn text-uppercase">Confirm Booking</button>
                                </div>
                            </form>

                            <script>
                                $('#submit').click(function(){
                                    console.log($('#fecha').val()+' '+$('#hora').val());
                                    $.ajax({
                                        url:'controller/calendarController.php',
                                        method: 'POST',
                                        data:{
                                            'nombre' : $('#nombre').val(),
                                            'telefono' : $('#telefono').val(),
                                            'email' : $('#email').val(),
                                            'nacimiento' : $('#nacimiento').val(),
                                            'fecha' : $('#fecha').val()+' '+$('#hora').val(),
                                            'mensaje': $('#mensaje').val()
                                        },
                                        success:function(data){
                                            console.log(data);
                                            alert('Se hizooo');
                                        },
                                        error:function(error){
                                            console.log(error);
                                            alert(':(');
                                        }
                                    })
                                });
                            </script>

                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Appointment Area -->

        <!--================ About Myself Area =================-->
        <section class="about_myself section_gap">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 pr-0">
                        <div class="about_img">
                            <img class="img-fluid w-100" src="img/about-me.jpg" alt="">
                        </div>
                    </div>

                    <div class="col-lg-6 pl-0">
                        <div class="about_box">
                            <div class="section-title-wrap text-left">
                                <h1>About Myself</h1>
                                <p>
                                    nappropriate behavior is often laughed off as “boys will be boys,” women face higher conduct standards especially in the
                                    workplace. That’s why it’s crucial that, as women, our behavior on the job is beyond reproach.
                                </p>
                            </div>

                            <div class="activity">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="activity_box">
                                            <div>
                                                <i class="lnr lnr-database"></i>
                                            </div>
                                            <h3>$<span class="counter">2.5</span> M</h3>
                                            <p>Total Donation</p>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6">
                                        <div class="activity_box">
                                            <div>
                                                <i class="lnr lnr-book"></i>
                                            </div>
                                            <h3 class="counter">1465</h3>
                                            <p>Total Project</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="activity_box">
                                            <div>
                                                <i class="lnr lnr-users"></i>
                                            </div>
                                            <h3 class="counter">3965</h3>
                                            <p>Total Volunteers</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="activity_box">
                                            <div>
                                                <i class="lnr lnr-users"></i>
                                            </div>
                                            <h3 class="counter">3965</h3>
                                            <p>Total Volunteers</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--================ End About Myself Area =================-->

        <!-- Start Feedback Area -->
        <section class="feedback_area section_gap relative">
            <div class="container">
                <div class="row justify-content-center section-title-wrap">
                    <div class="col-lg-12">
                        <h1>Enjoy our Client’s Feedback</h1>
                        <p>
                            Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                        </p>
                    </div>
                </div>

                <div class="feedback_contents justify-content-center align-items-center">
                    <div class="active-review-carusel owl-carousel">
                        <div class="row">
                            <div class="col-lg-6">
                                <img src="img/feedback-bg.jpg" alt="">
                            </div>

                            <div class="col-lg-6">
                                <div class="single-feedback-carusel">
                                    <div class="d-flex flex-row">
                                        <h4 class="">Fannie Rowe</h4>
                                        <div class="star">
                                            <span class="fa fa-star checked"></span>
                                            <span class="fa fa-star checked"></span>
                                            <span class="fa fa-star checked"></span>
                                            <span class="fa fa-star checked"></span>
                                            <span class="fa fa-star"></span>
                                        </div>
                                    </div>
                                    <p class="">
                                        Accessories Here you can find the best computer accessory for your laptop, monitor, printer, scanner, speaker. Here you can
                                        find the best computer accessory for your laptop, monitor, printer, scanner, speaker.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <img src="img/feedback-bg.jpg" alt="">
                            </div>

                            <div class="col-lg-6">
                                <div class="single-feedback-carusel">
                                    <div class="d-flex flex-row">
                                        <h4 class="">Fannie Rowe</h4>
                                        <div class="star">
                                            <span class="fa fa-star checked"></span>
                                            <span class="fa fa-star checked"></span>
                                            <span class="fa fa-star checked"></span>
                                            <span class="fa fa-star checked"></span>
                                            <span class="fa fa-star"></span>
                                        </div>
                                    </div>
                                    <p class="">
                                        Accessories Here you can find the best computer accessory for your laptop, monitor, printer, scanner, speaker. Here you can
                                        find the best computer accessory for your laptop, monitor, printer, scanner, speaker.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <img src="img/feedback-bg.jpg" alt="">
                            </div>

                            <div class="col-lg-6">
                                <div class="single-feedback-carusel">
                                    <div class="d-flex flex-row">
                                        <h4 class="">Fannie Rowe</h4>
                                        <div class="star">
                                            <span class="fa fa-star checked"></span>
                                            <span class="fa fa-star checked"></span>
                                            <span class="fa fa-star checked"></span>
                                            <span class="fa fa-star checked"></span>
                                            <span class="fa fa-star"></span>
                                        </div>
                                    </div>
                                    <p class="">
                                        Accessories Here you can find the best computer accessory for your laptop, monitor, printer, scanner, speaker. Here you can
                                        find the best computer accessory for your laptop, monitor, printer, scanner, speaker.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <img src="img/feedback-bg.jpg" alt="">
                            </div>

                            <div class="col-lg-6">
                                <div class="single-feedback-carusel">
                                    <div class="d-flex flex-row">
                                        <h4 class="">Fannie Rowe</h4>
                                        <div class="star">
                                            <span class="fa fa-star checked"></span>
                                            <span class="fa fa-star checked"></span>
                                            <span class="fa fa-star checked"></span>
                                            <span class="fa fa-star checked"></span>
                                            <span class="fa fa-star"></span>
                                        </div>
                                    </div>
                                    <p class="">
                                        Accessories Here you can find the best computer accessory for your laptop, monitor, printer, scanner, speaker. Here you can
                                        find the best computer accessory for your laptop, monitor, printer, scanner, speaker.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Feedback Area -->

        <?php require 'view/footer.php' ?>
    </body>

</html>