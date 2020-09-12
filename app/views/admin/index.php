<div class="content-wrapper">
  <div class="content">
    <!-- Top Statistics -->
    <div class="row">
      <div class="col-xl-3 col-sm-6">
        <div class="card card-mini mb-4">
          <div class="card-body">
            <h2 class="mb-1"></h2>
            <p>Online korisnika</p>
            <div class="chartjs-wrapper">
              <h3 class="online"><?= $online->online_numb ?></h3>

            </div>
            <?php

            // var_dump($orders);
            ?>
          </div>
        </div>
      </div>
      <div class="col-lg-12">
        <div class="card card-big mb-4">
          <div class="card-body">
            <h2 class="mb-1">Narudzbine</h2>
            <div class="scroll">
              <table>
                <?php

                // var_dump($orders);
                foreach ($orders as $order) :
                ?>
                  <tr>
                    <td><?= $order->first_name ?></td>
                    <td><?= $order->last_name ?></td>
                    <td><?= $order->date ?></td>
                  </tr>
                  <?php foreach ($order->details as $detail) : ?>
                    <tr>
                      <td class='order'><?= $detail->title ?></td>
                      <td class='order'><?= $detail->quantity ?></td>
                    </tr>
                  <?php endforeach; ?>

                <?php endforeach; ?>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-12">
        <div class="card card-big mb-4">
          <div class="card-body">
            <h2 class="mb-1">Greske</h2>
            <table class="scroll">
              <?php

              // var_dump($orders);
              foreach ($errors as $error) :
              ?>
                <tr>
                  <td><?= $error ?></td>

                </tr>


              <?php endforeach; ?>
            </table>
          </div>
        </div>
      </div>
      <div class="col-lg-12">
        <div class="card card-big mb-4">
          <div class="card-body">
            <h2 class="mb-1">Aktivnost</h2>
            <table class="scroll">
              <?php

              // var_dump($orders);
              foreach ($activity as $a) :
              ?>
                <tr>
                  <td><?= $a ?></td>

                </tr>


              <?php endforeach; ?>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>