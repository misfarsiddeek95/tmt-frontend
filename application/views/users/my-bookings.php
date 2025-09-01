<!DOCTYPE html>
<html lang="en">
  <head>
    <?php $this->load->view('includes/head'); ?>
    <title>My Bookings</title>
  </head>

  <body data-barba="wrapper">
    <?php $this->load->view('includes/preloader'); ?>
    <?php $this->load->view('users/includes/topbar'); ?>

    <div class="dashboard" data-x="dashboard" data-x-toggle="-is-sidebar-open">
        <?php $this->load->view('users/includes/sidebar'); ?>

        <div class="dashboard__main">
            <div class="dashboard__content bg-light-2">
                <div class="row y-gap-20 justify-between items-end pb-60 lg:pb-40 md:pb-32">
                    <div class="col-auto">
                        <h1 class="text-30 lh-14 fw-600">Booking History</h1>
                        <div class="text-15 text-light-1">
                            Find your bookings below.
                        </div>
                    </div>

                    <div class="col-auto"></div>
                </div>
                
                <div class="col-12">
                    <div class="<?=$this->session->flashdata('message_class') != '' ? $this->session->flashdata('message_class') : 'd-none' ?> items-center justify-between bg-error-1 pl-30 pr-20 py-30 rounded-8">
                        <div class="text-error-2 lh-1 fw-500"><?=$this->session->flashdata('message');?></div>
                        <div class="text-error-2 text-14 icon-close"></div>
                    </div>
                </div>
                <div class="py-30 px-30 rounded-4 bg-white shadow-3">
                    <div class="tabs -underline-2 js-tabs">
                        <div class="tabs__content pt-30 js-tabs-content">
                            <div class="tabs__pane -tab-item-1 is-tab-el-active">
                                <div class="overflow-scroll scroll-bar-1">
                                    <table class="table-3 -border-bottom col-12">
                                        <thead class="bg-light-2">
                                            <tr>
                                                <th>Booking Number</th>
                                                <th>Resort</th>
                                                <th>Booked Date</th>
                                                <th>Trip Date</th>
                                                <th>Total</th>
                                                <th>Paid</th>
                                                <th>Remain</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($allBookings as $row) { ?>
                                            <tr>
                                                <td><?=$row->booking_number?></td>
                                                <td><?=$row->hotel_name?></td>
                                                <td><?=date('d/m/Y',strtotime($row->created_at))?></td>
                                                <td class="lh-16">
                                                    Check in : <?=date('d/m/Y',strtotime($row->checkin_date))?><br />
                                                    Check out : <?=date('d/m/Y',strtotime($row->checkout_date))?>
                                                </td>
                                                <td class="fw-500"><?=$cur.''.number_format($row->total_amount,2)?></td>
                                                <td>$0</td>
                                                <td>$35</td>
                                                <td>
                                                    <span
                                                    class="rounded-100 py-4 px-10 text-center text-14 fw-500 bg-yellow-4 text-yellow-3"
                                                    >Pending</span
                                                    >
                                                </td>

                                                <td>
                                                    <a href="<?=base_url()?>view-booking?bk=<?=base64_encode($row->booking_number)?>" class="button h-35 px-24 -dark-1 bg-error-2 text-white fw-700" id="upload-button">
                                                        VIEW
                                                    </a>
                                                </td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php $this->load->view('users/includes/footer'); ?>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <?php $this->load->view('includes/js'); ?>
  </body>
</html>