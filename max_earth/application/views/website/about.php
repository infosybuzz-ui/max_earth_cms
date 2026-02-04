<main class="main">
        <section>
            <div class="container-fluid">
                <div class="row align-items-center min-vh-50 bg-primary-clip">
                    <!-- Text Content -->
                    <div class="col-lg-6 px-5">
                        <h1 class="display-5 fw-bold mb-3 text-white">Explore with our Services</h1>
                        <p class="lead text-white">Stay updated with our announcements with our Services</p>
                    </div>
                    <!-- Image Content -->
                    <div class="col-lg-6 p-0">
                        <img src="assets/img/blog/LatestNews.jpg" alt="News Banner" title="News Banner" loading="lazy"
                            class="img-fluid object-fit-cover clip-img">
                    </div>
                </div>
            </div>
        </section>
        <section>
            <div class="container-fluid">
                <div class="row align-items-center min-vh-50">
                    <section>
                        <div class="blog-single-area">
                            <div class="container-fluid">
                                <div class="row gx-4">
                                    <!-- Sidebar -->
                                    <div class="col-lg-3 col-md-12 mb-4 mb-lg-0 px-0">
                                        <aside class="sidebar h-100 d-flex flex-column">
                                            <div class="widget category mb-4">
                                                <h5 class="widget-title"><a href="#">Who We Are</a></h5>
												
                                                <div class="category-list list-group">
                                                    <?php 
													// print_r($sieLInks);
													// foreach($sieLInks as $url => $name){
														// echo '<a href="'.$url.'"
                                                        // class="list-group-item list-group-item-action d-flex justify-content-between align-items-center active">
																// <span><i class="fa-solid fa-arrow-right me-2"></i>'.$name.'</span>
															// </a>';
													// }
												?>
                                                    <a href="managementteam.html"
                                                        class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                                        <span><i class="fa-solid fa-arrow-right me-2"></i>Management Team</span>
                                                    </a>
                                                    <a href="accomplishment.html"
                                                        class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                                        <span><i
                                                                class="fa-solid fa-arrow-right me-2"></i>Accomplishments</span>
                                                    </a>
                                                    <a href="directordesk.html"
                                                        class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                                        <span><i class="fa-solid fa-arrow-right me-2"></i>Director's
                                                            Desk</span>
                                                    </a>
                                                    <a href="visionnmission.html"
                                                        class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                                        <span><i class="fa-solid fa-arrow-right me-2"></i>Vision &amp;
                                                            Mission</span>
                                                    </a>
                                                    <a href="maxearthadvantage.html"
                                                        class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                                        <span><i class="fa-solid fa-arrow-right me-2"></i>Advantage Max Earth</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </aside>
                                    </div>

                                    <!-- Main Content -->
                                    <div class="col-lg-9 col-md-12">
                                        <div class="blog-single-wrapper">
                                            <div class="blog-single-content">
                                                <section id="about" class="about-area p-5">
                                                    <div class="container">
                                                        <div class="row align-items-center gy-5">
                                                            <div class="col-12">
                                                                <?php echo $data['content_description']?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </section>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </section>

                </div>
            </div>
        </section>
    </main>

