<!DOCTYPE html>
<?php
   require_once $_SERVER['DOCUMENT_ROOT'] . "/admin/check_update.php";
?>

<html lang="en">
	<head>
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-163542949-1"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', 'UA-163542949-1', { 'optimize_id': 'GTM-53CCXWH'});
        </script>

        <!-- Google Tag Manager -->
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
            new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
            })(window,document,'script','dataLayer','GTM-P45ZHDP');
        </script>
        <!-- End Google Tag Manager -->

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title> Intelligent navigation of USA clinical trials </title>
        <meta name="description" content="Provide a graphical interface for navigating clinical trials in the USA repository. This website uses a biologist-curated hierarchy of both illness conditions and treatments to provide the user convenient categories.">
        <meta name="keywords" content="clinical trials, medical research, usa, disease hierarchy, drug, condition, navigation, graph" />
        <meta name="author" content="Max, Guang">

        <meta property="og:image" content="https://usclinicaltrials.org/imgs/clinical_index.png" />
        <meta property="og:url" content="https://usclinicaltrials.org" />
        <meta property="og:type" content="Website" />
        <meta property="og:title" content="Intelligent navigation of USA clinical trials" />
        <meta property="og:description" content="Provide a graphical interface for navigating clinical trials in the USA repository. This website uses a biologist-curated hierarchy of both illness conditions and treatments to provide the user convenient categories." />

        <link rel="apple-touch-icon" sizes="180x180" href="/imgs/apple-touch-icon.png" />
        <link rel="icon" type="image/png" sizes="32x32" href="/imgs/favicon-32x32.png" />
        <link rel="icon" type="image/png" sizes="16x16" href="/imgs/favicon-16x16.png" />
        <link rel="manifest" href="/imgs/site.webmanifest" />
        <link rel="mask-icon" href="/imgs/safari-pinned-tab.svg" color="#5bbad5" />
        <meta name="msapplication-TileColor" content="#da532c">
        <meta name="theme-color" content="#ffffff">

        <!-- Stylesheets -->

        <!-- Font -->
        <link rel="stylesheet preconnect preload" as="style" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" crossorigin="anonymous" />

		<!-- Bootstrap -->
        <link rel="stylesheet preconnect preload" as="style" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous" />

        <!-- Datatable -->
		<link rel="stylesheet preconnect preload" as="style" type="text/css" href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" crossorigin="anonymous" />
		<link rel="stylesheet preconnect preload" as="style" type="text/css" href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css" crossorigin="anonymous" />

        <!-- Date Range Picker -->
        <link rel="stylesheet preconnect preload" as="style" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" crossorigin="anonymous" />

        <!-- Tree -->
        <link rel="stylesheet preconnect preload" as="style" href="https://cdn.syncfusion.com/ej2/ej2-base/styles/material.css" crossorigin="anonymous" />
        <link rel="stylesheet preconnect preload" as="style" href="https://cdn.syncfusion.com/ej2/ej2-buttons/styles/material.css" crossorigin="anonymous" />
        <link rel="stylesheet preconnect preload" as="style" href="https://cdn.syncfusion.com/ej2/ej2-navigations/styles/material.css" crossorigin="anonymous" />

        <!-- Tour -->
        <link rel="stylesheet preload" as="style" href="/enjoyhint/enjoyhint.css" />

        <!-- Custom CSS -->
        <link rel="stylesheet preload" as="style" href="usclinicaltrails-custom.css" />
        
        <!-- Javascripts -->
        
        <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "ClinicalTrials",
            "name": "Intelligent navigation of USA clinical trials",
            "url": "http://usclinicaltrials.org",
            "description": "USclinicaltrials.org provide a graphical interface for navigating clinical trials in the USA repository. FDA regulations require that all trials registered in USA to be published on ClinicalTrials.Gov website. There are over one third of a million trials, and it is very difficult to navigate. USclinicaltrials.org allows the user to graphically select trials by conditions and treatment. It’s provides convenient output functions for selected trials in the dynamic bar graph, as well as export in several formats.This website uses a biologist-curated a hierarchy of both illness conditions and treatments to provide the user convenient categories. This allows comparison of related conditions or treatments. For example, for a given disease-treatment combination a patient might desire to see alternative treatments that fit his disease, while a company might want to see alternative diseases, which might respond to its treatment.",
            "contactPoint": {
                "@type": "ContactPoint",
                "telephone": "+1-617-775-9778",
                "email": "info@flowcell.co",
                "address": "29 Littles Point Rd. Swampscott, MA 01907, USA",
                "contactType": "Customer service"
            }
        }
        </script>
        
        <!-- JQuery -->
        <script defer src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha384-vtXRMe3mGCbOeY7l30aIg8H9p3GdeSe4IFlP6G8JMa7o7lXvnz3GFKzPxzJdPfGK" crossorigin="anonymous"></script>
		<script defer src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.3.0/jquery.form.min.js" integrity="sha384-qlmct0AOBiA2VPZkMY3+2WqkHtIQ9lSdAsAn5RUJD/3vA5MKDgSGcdmIv4ycVxyn" crossorigin="anonymous"></script>
		
        <!-- Bootstrap -->
        <script defer src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script defer src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    </head>
    <body>
        <!-- Google Tag Manager (noscript) -->
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-P45ZHDP"
        height="0" width="0"></iframe></noscript>
        <!-- End Google Tag Manager (noscript) -->

        <div class="lds-container" id="waiting">
			<div class="lds-dual-ring">Loading data, please standby...</div>
		</div>
        <!-- Main Contents -->
        <div class="top-container"> 
            <nav class="navbar navbar-expand-md navbar-light">
                <div class="d-flex flex-fill align-items-center">
                    <div class="navbar-brand">
                            <img src="/imgs/clinical_index.png" id="brand-img" alt="clinical trials">
                    </div>
                    <button class="navbar-toggler ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <div class="navbar-nav ml-auto">
                        <button type="button" id="start_tour"
                        title="Tour Website" data-toggle="tooltip" data-placement="bottom"
                        class="btn btn-outline-info btn-flat hidden-xs nav-item mr-2">
                        &nbsp;<i class="fa fa-paper-plane" aria-hidden="true"></i>&nbsp;
                        </button>
                        <button id="btn-search" class="btn btn-outline-primary nav-item mr-2" data-toggle="modal" data-target="#search-modal">
                            <i class="fa fa-search" aria-hidden="true"></i>&nbsp;&nbsp;Search
                        </button>
                        <button id="btn-corona" class="btn btn-outline-primary nav-item mr-2" style="padding: 0.5rem 1rem">
                            <i class="fa fa-search" aria-hidden="true"></i>&nbsp;&nbsp; COVID-19
                        </button>
                        <!-- Cancer button hidden
                        <button id="btn-cancer" title="IN DEVELOPMENT" class="btn btn-outline-warning nav-item mr-2" style="padding: 0.5rem 1rem">
                            <i class="fa fa-search" aria-hidden="true"></i>&nbsp;&nbsp; Cancer
                        </button>
                        -->
                        <button id="btn-feedback" title="Write Feedback for this website." data-toggle="modal" data-target="#feedback-container" class="btn btn-outline-info btn-flat hidden-xs nav-item mr-2">
                            <i class="fa fa-comments-o" aria-hidden="true"></i>&nbsp;&nbsp;Feedback
                        </button>
                        <button id="btn-aboutus" class="btn btn-outline-primary nav-item mr-2"
                            data-toggle="modal" data-target="#about-modal">
                            <i class="fa fa-question" aria-hidden="true"></i>&nbsp;&nbsp;About Us
                        </button>
                        <a id="btn-ffl" class="btn btn-outline-info nav-item mr-2" title="Visit Our Online Store" href="https://fluidsforlife.com/category/system.html" target="_blank">
                            <i class="fa fa-shopping-cart" aria-hidden="true"></i>&nbsp;&nbsp;Micro-physiological systems
                        </a>
                    </div>
                </div>
            </nav>
            <div class="row">
                <div class="col-12">
                    <h1 class="text-center" id="title_graph"> Clinical Trials Grouped by Conditions</h1>
                </div>
            </div>
            <!-- Chart Graph -->
            <div class="row box box-border">
                <div class="col-12 col-lg-4 col-xl-3">
                    <ul class="nav nav-tabs nav-justified" id="graph-tab">
                        <li class=" nav-item" id="btn-condition"><a class="nav-link font-12 active" data-toggle="tab" href="#graph-tab-condition">Conditions</a></li>
                        <li class=" nav-item" id="btn-modifier"><a class="nav-link font-12" data-toggle="tab" href="#graph-tab-modifier">Modifiers</a></li>
                        <li class=" nav-item" id="btn-treatment"><a class="nav-link font-12" data-toggle="tab" href="#graph-tab-drug">Treatments</a></li>
                    </ul>
                    <div class="tab-content" id="graph-tabs">
                        <div class="tab-pane graph-left active" id="graph-tab-condition">
                            <!-- Condition Tree -->
                            <div id="condition-search-tree"></div>
                        </div>
                        <!-- Modifier Tree -->
                        <div class="tab-pane graph-left fade" id="graph-tab-modifier">
                            <!-- Condition Tree -->
                            <div id="modifier-tree"></div>
                        </div>
                        <!-- Drug -->
                        <div class="tab-pane graph-left fade" id="graph-tab-drug">
                            <div id="drug-search-tree"></div>
                        </div>
                    </div>
                </div>
                <!-- Chart Graph -->
                <div class="col-12 col-lg-8 col-xl-9 enable-scroll">
                    <div class="chart-container">
                        <canvas id="myChart"></canvas>
                    </div>
                </div>
            </div>
            
            <!-- Data table -->
            <h2 class="text-center">Clinical Trials Data Table For Graph</h2>
            <div class="row box">
                <div class="col-12" id="datatable-container">
                    <table id="study-table" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>NCT ID</th>
                                <th>Title</th>
                                <th>Enrollment</th>
                                <th>Status</th>
                                <th>Study Types</th>
                                <th>Conditions</th>
                                <th>Interventions</th>
                                <th>Outcome Measures</th>
                                <th>Phases</th>
                                <th>Study Designs</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>

            <!-- Feedback -->
        <div class="modal fade show" id="feedback-container" tabindex="-1" role="dialog" aria-modal="true">
			<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
				<div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title">Send Feedback</h2>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="col-12">
                            <form id="feedForm" action="feedback/add.php" method="post">
                                <label for="feedback">We would love to hear from you! (<i>250 character limit please</i>)</label>
                                <textarea rows="5" class="form-control" id="feedback" name="comment" required="required" maxlength="250"></textarea>
                                <div class="pb-2"></div>
                                <input type="submit" value="Send Message" class="btn btn-primary">
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary close-feed" data-dismiss="modal">Close</button>
                    </div>
				</div>
			</div>
		</div>
    </div>

        <!-- Search Modal -->
        <div class="modal fade" id="search-modal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title" id="exampleModalLongTitle">Search Studies</h2>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <ul class="nav nav-tabs nav-justified">
                            <li class=" nav-item"><a class="nav-link active" data-toggle="tab" href="#tab-condition">Conditions</a></li>
                            <li class=" nav-item"><a class="nav-link" data-toggle="tab" href="#tab-drug">Treatments</a></li>
                            <li class=" nav-item"><a class="nav-link" data-toggle="tab" href="#tab-other">Others</a></li>
                        </ul>
                        <div class="tab-content">
                            <!-- Condition Tree -->
                            <div class="tab-pane container active" id="tab-condition">
                                <div class="row modal-body-content">
					                <div id="condition-tree">
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane container fade" id="tab-drug">
                                <div class="row modal-body-content">
                                    <div id="drug-tree">
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane container fade" id="tab-other">
                                <form id="search-other-form">
                                    <div class="row modal-body-content">
                                        <!-- Status -->
                                        <div class="col-12 item-box">
                                            <label>Status: </label>
                                            <div class="row sub-item-box">
                                                <div class="col-6">
                                                    <label> Recruitment: </label>
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input name="search-status" type="checkbox" class="form-check-input" value="Not yet recruiting" checked>Not yet recruiting
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input name="search-status" type="checkbox" class="form-check-input" value="Recruiting" checked>Recruiting
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input name="search-status" type="checkbox" class="form-check-input" value="Enrolling by invitation" checked>Enrolling by invitation
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input name="search-status" type="checkbox" class="form-check-input" value="Active, not recruiting" checked>Active, not recruiting
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input name="search-status" type="checkbox" class="form-check-input" value="Suspended" checked>Suspended
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input name="search-status" type="checkbox" class="form-check-input" value="Terminated" checked>Terminated
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input name="search-status" type="checkbox" class="form-check-input" value="Completed" checked>Completed
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input name="search-status" type="checkbox" class="form-check-input" value="Withdrawn" checked>Withdrawn
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input name="search-status" type="checkbox" class="form-check-input" value="Unknown status" checked>Unknown status
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <label for="search-age-from"> Expanded Access: </label>
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input name="search-status" type="checkbox" class="form-check-input" value="Available" checked>Available
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input name="search-status" type="checkbox" class="form-check-input" value="No longer available" checked>No longer available
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input name="search-status" type="checkbox" class="form-check-input" value="Temporarily not available" checked>Temporarily not available
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input name="search-status" type="checkbox" class="form-check-input" value="Approved for marketing" checked>Approved for marketing
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Phase -->
                                        <div class="col-12 item-box">
                                            <label>Phase: </label>
                                            <div class="row sub-item-box">
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input name="search-phase" type="checkbox" class="form-check-input" value="Early Phase 1" checked>Early Phase 1
                                                    </label>
                                                </div>&nbsp;&nbsp;&nbsp;
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input name="search-phase" type="checkbox" class="form-check-input" value="Phase 1" checked>Phase 1
                                                    </label>
                                                </div>&nbsp;&nbsp;&nbsp;
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input name="search-phase" type="checkbox" class="form-check-input" value="Phase 2" checked>Phase 2
                                                    </label>
                                                </div>&nbsp;&nbsp;&nbsp;
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input name="search-phase" type="checkbox" class="form-check-input" value="Phase 3" checked>Phase 3
                                                    </label>
                                                </div>&nbsp;&nbsp;&nbsp;
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input name="search-phase" type="checkbox" class="form-check-input" value="Phase 4" checked>Phase 4
                                                    </label>
                                                </div>&nbsp;&nbsp;&nbsp;
                                                <div class="form-check">
                                                    <label class="form-check-label">
                                                        <input name="search-phase" type="checkbox" class="form-check-input" value="Not Applicable" checked>Not Applicable
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-6 item-box">
                                            <label for="search-title">Title :</label>
                                            <input id="search-title" name="search-title" class="form-control">
                                        </div>
                                        <div class="col-12 col-lg-6 item-box">
                                            <label for="search-measure">Outcome Measure :</label>
                                            <input id="search-measure" name="search-measure" class="form-control">
                                        </div>
                                        <div class="col-12 col-lg-6 item-box">
                                            <label for="search-design">Design :</label>
                                            <input id="search-design" name="search-design" class="form-control">
                                        </div>
                                        <div class="col-12 col-lg-6 item-box">
                                            <label for="search-type">Type :</label>
                                            <select id="search-type" name="search-type" class="form-control">
                                                <option value="">All</option>
                                                <option>Expanded Access</option>
                                                <option>Interventional</option>
                                                <option>Observational</option>
                                            </select>
                                        </div>
                                        <div class="col-12 col-lg-6 item-box">
                                            <label for="search-sex">Sex :</label>
                                            <select id="search-sex" name="search-sex" class="form-control">
                                                <option value="">All</option>
                                                <option>Male</option>
                                                <option>Female</option>
                                            </select>
                                        </div>
                                        <!-- Start Date -->
                                        <div class="col-12 col-lg-6 item-box">
                                            <label for="search-start">Study Start: </label>
                                            <input name="search-start" id="search-start" class="form-control date-range">
                                        </div>
                                        <!-- complete date -->
                                        <div class="col-12 col-lg-6 item-box">
                                            <label for="search-complete">Primary Completion: </label>
                                            <input name="search-complete" id="search-complete" class="form-control date-range">
                                        </div>
                                        <!-- First POsted -->
                                        <div class="col-12 col-lg-6 item-box">
                                            <label for="search-first-post">First Posted: </label>
                                            <input name="search-first-post" id="search-first-post" class="form-control date-range">
                                        </div>
                                        <!-- Last Update -->
                                        <div class="col-12 col-lg-6 item-box">
                                            <label for="search-last-post">Last Update Posted: </label>
                                            <input name="search-last-post" id="search-last-post" class="form-control date-range">
                                        </div>
                                        <!-- Age -->
                                        <div class="col-12 item-box">
                                            <label>Age: </label>
                                            <div class="row sub-item-box">
                                                <div class="col-6">
                                                    <label for="search-age-from"> From </label>
                                                    <input id="search-age-from" name="search-age-from" class="form-control" type="number" min="1">
                                                </div>
                                                <div class="col-6">
                                                    <label for="search-age-from"> To </label>
                                                    <input id="search-age-to" name="search-age-to" class="form-control" type="number" min="1">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Age group -->
                                        <div class="col-12 item-box">
                                            <label>Age Group: </label>
                                            <div class="row sub-item-box">
                                                <div class="form-check-inline">
                                                    <label class="form-check-label">
                                                        <input name="search-age-group" type="checkbox" class="form-check-input" value="Child">Child (birth - 17)
                                                    </label>
                                                </div>&nbsp;&nbsp;&nbsp;
                                                <div class="form-check-inline">
                                                    <label class="form-check-label">
                                                        <input name="search-age-group" type="checkbox" class="form-check-input" value="Adult">Adult (18 - 64)
                                                    </label>
                                                </div>&nbsp;&nbsp;&nbsp;
                                                <div class="form-check-inline">
                                                    <label class="form-check-label">
                                                        <input name="search-age-group" type="checkbox" class="form-check-input" value="Older Adult">Older Adult (65+)
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="search-btn-main" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i>&nbsp;&nbsp;Search</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- About Modal -->
        <div class="modal fade" id="about-modal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title">About us</h2>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>
                            <strong>USclinicaltrials.org</strong> provides a <strong>graphical interface</strong> for intelligent navigation of <strong>clinical trials</strong> in the <strong>USA repository</strong>. 
                            FDA regulations require that all trials registered in USA to be published on <a href="https://clinicaltrials.gov">ClinicalTrials.Gov</a> website. 
                            There are over one third of a million trials, and it is very difficult to navigate.
                        </p>
                        <p>
                            USclinicaltrials.org allows the user to graphically select trials by <strong>conditions</strong> and <strong>treatment</strong>.
                            It’s provides <strong>convenient output functions</strong> for selected trials in the dynamic bar graph, as well as <strong>export</strong> in several formats.
                        </p>
                        <p>
                            This website uses a <strong>biologist-curated hierarchy of both illness conditions and treatments</strong> to provide the user convenient categories. 
                            This allows <strong>comparison of related conditions or treatments</strong>. 
                            For example, for a given disease-treatment combination a patient might desire to see alternative treatments that fit his disease, while a company might want to see alternative diseases, which might respond to its treatment.
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Footer -->
        <footer class="page-footer font-small">
            <hr/>
            <!-- Links -->
            <div class="container">
                <div class="row justify-content-center py-2">
                    <div class="col-auto"> <a href="https://fluidsforlife.com/">Fluids For Life</a> </div>
                    <div class="col-auto border-left"> <a href="https://flowcell.co">Flowcell</a> </div>
                    <div class="col-auto border-left"> <a href="https://health-sherlock.com/">Health Sherlock</a> </div>
                </div>
            </div>
            
            <!-- Copyright -->
            <div class="footer-copyright text-center pb-3">Copyright &copy; <?php echo date("Y"); ?>
                <a href="https://usclinicaltrials.org/"> usclinicaltrials.org</a> . All rights reserved.
            </div>
            <!-- Copyright -->

        </footer>
        <!-- Footer -->
        
        <!-- Javascripts -->

        <!-- Datatable -->
        <script defer type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
		<script defer type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
		<script defer type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
		<script defer type="text/javascript" charset="utf8" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
		<script defer type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js"></script>
		<script defer type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
        
        <!-- Chart -->
        <script defer src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3"></script>
        
        <!-- Date RangePicker -->
        <script defer type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
        <script defer type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

        <!-- Treeview -->
        <!-- Generated from https://crg.syncfusion.com/ using the following json settings 
        {
            "components": [
                "button",
                "check-box",
                "treeview"
            ],
            "minified": "true",
            "themes": [
                "material"
            ],
            "version": "19.1.56",
            "name": "ej2.custom",
            "isMinified": true,
            "injectables": {}
        }
        -->
        <script defer src="/ej2/ej2.custom.min.js" type="text/javascript"></script>

        <!-- Tour -->
        <script defer src="/enjoyhint/enjoyhint.js"></script>
        <!-- Page Js -->
        <script defer src="index.js"></script>

    </body>
</html>
