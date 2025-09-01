<!DOCTYPE html>
<html lang="en">
  <head>
    <?php $this->load->view('includes/head'); ?>

    <title>Dashboard</title>
  </head>

  <body data-barba="wrapper">
    <?php $this->load->view('includes/preloader'); ?>
    <?php $this->load->view('users/includes/topbar'); ?>

    <div class="dashboard" data-x="dashboard" data-x-toggle="-is-sidebar-open">
      <?php $this->load->view('users/includes/sidebar'); ?>
      <div class="dashboard__main">
        <div class="dashboard__content bg-light-2">
          <div
            class="row y-gap-20 justify-between items-end pb-60 lg:pb-40 md:pb-32"
          >
            <div class="col-auto">
              <h1 class="text-30 lh-14 fw-600">Dashboard</h1>
              <div class="text-15 text-light-1">
                Find your account summary below.
              </div>
            </div>

            <div class="col-auto"></div>
          </div>

          <div class="row y-gap-30">
            <div class="col-xl-6 col-md-6">
              <div class="py-30 px-30 rounded-4 bg-white shadow-3">
                <div class="row y-gap-20 justify-between items-center">
                  <div class="col-auto">
                    <div class="fw-500 lh-14">Bookings</div>
                    <div class="text-26 lh-16 fw-600 mt-5"><?=str_pad(number_format($totalBookingCounts), 2, "0", STR_PAD_LEFT)?></div>
                    <div class="text-15 lh-14 text-light-1 mt-5">
                      Total bookings
                    </div>
                  </div>

                  <div class="col-auto">
                    <img src="<?=base_url()?>assets/img/dashboard/icons/1.svg" alt="icon" />
                  </div>
                </div>
              </div>
            </div>

            <div class="col-xl-6 col-md-6">
              <div class="py-30 px-30 rounded-4 bg-white shadow-3">
                <div class="row y-gap-20 justify-between items-center">
                  <div class="col-auto">
                    <div class="fw-500 lh-14">Wishlist</div>
                    <div class="text-26 lh-16 fw-600 mt-5"><?=str_pad(number_format($totalWishlistCounts), 2, "0", STR_PAD_LEFT)?></div>
                    <div class="text-15 lh-14 text-light-1 mt-5">
                      Total wishlist
                    </div>
                  </div>

                  <div class="col-auto">
                    <img src="<?=base_url()?>assets/img/dashboard/icons/2.svg" alt="icon" />
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="row y-gap-30 pt-20">
            <div class="col-xl-12 col-md-12">
              <div class="py-30 px-30 rounded-4 bg-white shadow-3">
                <div class="d-flex justify-between items-center">
                  <h2 class="text-18 lh-1 fw-500">Recent Bookings</h2>

                  <div class="">
                    <a href="<?=base_url('my-bookings')?>" class="text-14 text-blue-1 fw-500 underline"
                      >View All</a
                    >
                  </div>
                </div>

                <div class="overflow-scroll scroll-bar-1 pt-30">
                  <table class="table-2 col-12">
                    <thead class="">
                      <tr>
                        <th>#</th>
                        <th>Booking Number</th>
                        <th>Resort</th>
                        <th>Total</th>
                        <th>Paid</th>
                        <th>Status</th>
                        <th>Created At</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($recentBooking as $key => $row) { ?>
                      <tr>
                        <td>#<?=($key + 1)?></td>
                        <td><?=$row->booking_number?></td>
                        <td><?=$row->hotel_name?></td>
                        <td class="fw-500"><?=$cur.''.number_format($row->total_amount,2)?></td>
                        <td>$0</td>
                        <td>
                          <div
                            class="rounded-100 py-4 text-center col-12 text-14 fw-500 bg-yellow-4 text-yellow-3"
                          >
                            Pending
                          </div>
                        </td>
                        <td><?=date('d/m/Y', strtotime($row->created_at))?><br /><?=date('H:i', strtotime($row->created_at))?></td>
                      </tr>
                      <?php } ?>
                    </tbody>
                  </table>
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
