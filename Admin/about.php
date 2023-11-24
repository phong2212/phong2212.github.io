<?php
include __DIR__ . '/../Apps/bootstrap.php';
$page = 'about';
require_once __DIR__ . '/components/header.php';
require_once __DIR__ . '/components/linkCssJs.php';
?>

<main>
  <!-- About Us -->
  <section id="aboutus">
    <div class="container p-5 bg-light rounded my-5">
      <div class="row justify-content-between">
        <div class="col-6">
          <div class="animate__animated animate__fadeInUp animate__paused">
            <h5 class="subtitle m-0">VỀ CHÚNG TÔI</h5>
          </div>
          <div class="animate__animated animate__fadeInUp animate__paused">
            <h1 class="title">
              Khám phá mọi ngóc ngách của thế giới cùng chúng tôi
            </h1>
          </div>
          <div class="animate__animated animate__slow animate__fadeInUp animate__paused">
            <p class="desc">
              Chúng tôi là một công ty du lịch chuyên nghiệp, với đội ngũ
              nhân viên giàu kinh nghiệm và nhiệt tình. Chúng tôi sẽ giúp
              bạn tìm kiếm và lên kế hoạch cho chuyến đi hoàn hảo, từ việc
              lựa chọn điểm đến, đặt vé máy bay, khách sạn, cho đến các hoạt
              động tham quan, giải trí.
            </p>
          </div>
          <div class="animate__animated animate__slower animate__fadeInUp animate__paused">
            <p class="desc">
              Với kinh nghiệm và sự hiểu biết sâu sắc về du lịch, chúng tôi
              sẽ giúp bạn khám phá thế giới một cách trọn vẹn nhất. Chúng
              tôi sẽ lắng nghe nhu cầu và sở thích của bạn để đưa ra những
              gợi ý phù hợp nhất. Chúng tôi cũng sẽ hỗ trợ bạn giải quyết
              mọi vấn đề phát sinh trong chuyến đi, đảm bảo bạn có một kỳ
              nghỉ đáng nhớ.
            </p>
          </div>
          <div class="animate__animated animate__slower animate__fadeInUp animate__paused">
            <p class="desc">
              Chúng tôi tin rằng du lịch là một cách tuyệt vời để khám phá
              thế giới, mở rộng tầm nhìn và tìm hiểu về các nền văn hóa khác
              nhau. Chúng tôi mong muốn được đồng hành cùng bạn trong những
              chuyến đi khám phá, để cùng bạn tạo nên những kỷ niệm đáng
              nhớ.
            </p>
            <p class="desc">
              Hãy liên hệ với chúng tôi ngay hôm nay để được tư vấn và đặt
              tour du lịch. Chúng tôi sẽ giúp bạn biến ước mơ du lịch thành
              hiện thực.
            </p>
          </div>
        </div>
        <div class="col-5 d-flex align-items-center">
          <div class="row">
            <div class="col-6 animate__animated animate__fadeInUp animate__paused">
              <img src="./assets/img/potrait-1.jpg" alt="" class="img-fluid shadow-lg rounded" />
            </div>
            <div class="col-6 animate__animated animate__slow animate__fadeInUp animate__paused mt-5">
              <img src="./assets/img/potrait-2.jpg" alt="" class="img-fluid shadow-lg rounded" />
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Choose Us -->
  <section id="choose">
    <div class="container p-5 bg-light rounded my-5">
      <div class="row justify-content-between">
        <div class="animate__animated animate__fadeInUp animate__paused">
          <h5 class="subtitle m-0">TẠI SAO NÊN ĐẶT CHỖ VỚI TRAVEL HUB?</h5>
        </div>
        <div class="animate__animated animate__fadeInUp animate__paused">
          <h1 class="title">
            TRAVEL HUB - Giải pháp du lịch toàn diện cho bạn
          </h1>
        </div>
        <div class="animate__animated animate__fadeInUp animate__paused">
          <div class="row justify-content-between mt-5 text-center p-0 m-0">
            <div class="col-3">
              <div class="choose__icon mx-auto">
                <img class="img-fluid" src="./assets/img/icon-1.png" alt="" />
              </div>
              <div class="choose__header">Giải pháp du lịch hoàn thiện</div>
              <div class="choose_desc">
                Giải pháp toàn diện - giúp bạn tìm chuyến bay và khách sạn
                khắp Việt Nam và Đông Nam Á một cách tiết kiệm.
              </div>
            </div>
            <div class="col-3">
              <div class="choose__icon mx-auto">
                <img class="img-fluid" src="./assets/img/icon-2.png" alt="" />
              </div>
              <div class="choose__header">Giá rẻ mỗi ngày</div>
              <div class="choose_desc">
                Giá bạn thấy là giá bạn trả! Dễ dàng so sánh khi không cần
                phải trả thêm chi phí ẩn!
              </div>
            </div>
            <div class="col-3">
              <div class="choose__icon mx-auto">
                <img class="img-fluid mx-auto" src="./assets/img/icon-3.png" alt="" />
              </div>
              <div class="choose__header">
                Phương thức thanh toán an toàn
              </div>
              <div class="choose_desc">
                Giao dịch trực tuyến an toàn với nhiều lựa chọn như thanh
                toán tại cửa hàng tiện lợi, chuyển khoản ngân hàng, thẻ tín
                dụng đến Internet Banking. Không tính phí giao dịch.
              </div>
            </div>
            <div class="col-3">
              <div class="choose__icon mx-auto">
                <img class="img-fluid mx-auto" src="./assets/img/icon-4.png" alt="" />
              </div>
              <div class="choose__header">Hỗ trợ khách hàng 24/7</div>
              <div class="choose_desc">
                Đội ngũ nhân viên hỗ trợ khách hàng luôn sẵn sàng giúp đỡ
                bạn trong từng bước của quá trình đặt vé
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Partners -->
  <section id="partners">
    <div class="container p-5 bg-light rounded my-5">
      <div class="row">
        <div class="animate__animated animate__fadeInUp animate__paused">
          <h5 class="subtitle m-0">ĐỐI TÁC HÀNG KHÔNG</h5>
        </div>
        <div class="animate__animated animate__fadeInUp animate__paused">
          <h1 class="title">Đối tác hàng không nội địa và quốc tế</h1>
        </div>
        <div class="animate__animated animate__slow animate__fadeInUp animate__paused">
          <p class="desc">
            Những đối tác hàng không toàn cầu sẽ chắp cánh đưa bạn đến mọi
            địa điểm trên thế giới.
          </p>
        </div>
      </div>
      <div class="animate__animated animate__slow animate__fadeInUp animate__paused">
        <div class="row justify-content-between">
          <div class="col-2 mb-3 d-flex align-items-center">
            <img src="./assets/img/partner-1.png" class="img-fluid" alt="" />
          </div>
          <div class="col-2 mb-3 d-flex align-items-center">
            <img src="./assets/img/partner-2.png" class="img-fluid" alt="" />
          </div>
          <div class="col-2 mb-3 d-flex align-items-center">
            <img src="./assets/img/partner-3.png" class="img-fluid" alt="" />
          </div>
          <div class="col-2 mb-3 d-flex align-items-center">
            <img src="./assets/img/partner-4.png" class="img-fluid" alt="" />
          </div>
          <div class="col-2 mb-3 d-flex align-items-center">
            <img src="./assets/img/partner-5.png" class="img-fluid" alt="" />
          </div>
          <div class="col-2 mb-3 d-flex align-items-center">
            <img src="./assets/img/partner-6.png" class="img-fluid" alt="" />
          </div>
        </div>
      </div>

      <div class="row">
        <div class="animate__animated animate__fadeInUp animate__paused">
          <h5 class="subtitle m-0">ĐỐI TÁC KHÁCH SẠN</h5>
        </div>
        <div class="animate__animated animate__fadeInUp animate__paused">
          <h1 class="title">Đối tác khách sạn trong nước và quốc tế</h1>
        </div>
        <div class="animate__animated animate__slow animate__fadeInUp animate__paused">
          <p class="desc">
            Chúng tôi hợp tác với các chuỗi khách sạn trên toàn thế giới để
            bảo đảm mang lại kỳ nghỉ tuyệt vời nhất tại mọi điểm đến trong
            mơ của bạn!
          </p>
        </div>
      </div>
      <div class="animate__animated animate__slow animate__fadeInUp animate__paused">
        <div class="row justify-content-between">
          <div class="col-2 mt-3 d-flex align-items-center">
            <img src="./assets/img/partner-7.png" class="img-fluid" alt="" />
          </div>
          <div class="col-2 mt-3 d-flex align-items-center">
            <img src="./assets/img/partner-8.png" class="img-fluid" alt="" />
          </div>
          <div class="col-2 mt-3 d-flex align-items-center">
            <img src="./assets/img/partner-9.png" class="img-fluid" alt="" />
          </div>
          <div class="col-2 mt-3 d-flex align-items-center">
            <img src="./assets/img/partner-10.png" class="img-fluid" alt="" />
          </div>
          <div class="col-2 mt-3 d-flex align-items-center">
            <img src="./assets/img/partner-11.png" class="img-fluid" alt="" />
          </div>
          <div class="col-2 mt-3 d-flex align-items-center">
            <img src="./assets/img/partner-12.png" class="img-fluid" alt="" />
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- FAQ -->
  <section id="faq">
    <div class="container p-5 bg-light rounded my-5">
      <div class="row justify-content-between">
        <div class="col-6">
          <div class="animate__animated animate__fadeInUp animate__paused">
            <h5 class="subtitle m-0">KHÁCH HÀNG VUI VẺ</h5>
          </div>
          <div class="animate__animated animate__fadeInUp animate__paused">
            <h1 class="title">Phản hồi tích cực</h1>
          </div>
          <div class="animate__animated animate__slow animate__fadeInLeft animate__paused">
            <div id="carouselComment" class="carousel slide">
              <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselComment" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselComment" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselComment" data-bs-slide-to="2" aria-label="Slide 3"></button>
              </div>
              <div class="carousel-inner rounded">
                <div class="carousel-item active">
                  <div class="d-flex align-items-center" style="
                          height: 24rem;
                          background-color: var(--sub-heading);
                        ">
                    <div class="m-5 text-center">
                      <p class="py-3 text-white">
                        "Mình đã trải nghiệm Thái Lan, Singapore Malaysia,
                        Châu Âu, Nga của TRAVELHUB . Dịch vụ tốt, hướng dẫn
                        viên nhiệt tình chu đáo, đặc biệt giá cả là tốt nhất
                        thị trường."
                      </p>
                      <div class="px-3 text-white">
                        <strong>Phúc Lê</strong>
                      </div>
                      <div class="px-3 text-warning">
                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="carousel-item">
                  <div class="d-flex align-items-center" style="
                          height: 24rem;
                          background-color: var(--sub-heading);
                        ">
                    <div class="m-5 text-center">
                      <p class="py-3 text-white">
                        "Trên cả tuyệt vời. Điểm đến đẹp, ý nghĩa, trải
                        nghiệm thực tế. Ăn ngủ tuyệt vời. HDV chu đáo, nhiệt
                        tình! Hẹn TRAVELHUB một ngày không xa nhé."
                      </p>
                      <div class="px-3 text-white">
                        <strong>Đạt Nguyễn</strong>
                      </div>
                      <div class="px-3 text-warning">
                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="carousel-item">
                  <div class="d-flex align-items-center" style="
                          height: 24rem;
                          background-color: var(--sub-heading);
                        ">
                    <div class="m-5 text-center">
                      <p class="py-3 text-white">
                        "Dịch vụ tốt, hdv thân thiện, vui tính, nhiệt tình.
                        Toàn thể du khách hài lòng với dịch vụ của cty và
                        hdv. Hẹn 1ngày k xa sẽ tiếp tục đồng hành với cty."
                      </p>
                      <div class="px-3 text-white">
                        <strong>Phong Lê</strong>
                      </div>
                      <div class="px-3 text-warning">
                        <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star-half-stroke"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <button class="carousel-control-prev" type="button" data-bs-target="#carouselComment" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
              </button>
              <button class="carousel-control-next" type="button" data-bs-target="#carouselComment" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
              </button>
            </div>
          </div>
        </div>
        <div class="col-6">
          <div class="animate__animated animate__fadeInUp animate__paused">
            <h5 class="subtitle m-0">FAQ</h5>
          </div>
          <div class="animate__animated animate__fadeInUp animate__paused">
            <h1 class="title">Những câu hỏi thường gặp</h1>
          </div>
          <div class="animate__animated animate__slow animate__fadeInRight animate__paused">
            <div class="accordion" id="accordionFAQ">
              <div class="accordion-item">
                <h2 class="accordion-header">
                  <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    Điều kiện đăng ký tour là gì?
                  </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionFAQ">
                  <div class="accordion-body">
                    <p>
                      Đối với khách hàng Việt Nam: Có hộ chiếu còn hạn sử
                      dụng ít nhất 6 tháng, visa (đối với các nước cần
                      visa), đầy đủ giấy tờ tùy thân.
                    </p>
                    <p>
                      Đối với khách hàng nước ngoài: Có hộ chiếu còn hạn sử
                      dụng ít nhất 6 tháng, visa (đối với các nước cần
                      visa), đầy đủ giấy tờ tùy thân.
                    </p>
                  </div>
                </div>
              </div>
              <div class="accordion-item">
                <h2 class="accordion-header">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    Cách đổi tiền khi đi du lịch nước ngoài?
                  </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionFAQ">
                  <div class="accordion-body">
                    <p>
                      Có thể đổi tiền tại ngân hàng, tiệm vàng hoặc các đại
                      lý đổi tiền.
                    </p>
                    <p>
                      Nên đổi tiền tại ngân hàng để đảm bảo an toàn và tỷ
                      giá tốt.
                    </p>
                    <p>
                      Nên đổi số tiền vừa đủ để sử dụng trong thời gian du
                      lịch.
                    </p>
                  </div>
                </div>
              </div>
              <div class="accordion-item">
                <h2 class="accordion-header">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                    Cần phải đặt tour trước bao lâu?
                  </button>
                </h2>
                <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionFAQ">
                  <div class="accordion-body">
                    <p>
                      Thời gian đặt tour phụ thuộc vào thời điểm du lịch và
                      điểm đến.
                    </p>
                    <p>
                      Đối với các tour du lịch trong nước, nên đặt tour
                      trước ít nhất 1 tuần để có giá tốt và đảm bảo chỗ.
                    </p>
                    <p>
                      Đối với các tour du lịch nước ngoài, nên đặt tour
                      trước ít nhất 2 tháng để có giá tốt và đảm bảo chỗ.
                    </p>
                  </div>
                </div>
              </div>
              <div class="accordion-item">
                <h2 class="accordion-header">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                    Cách thanh toán tour như thế nào?
                  </button>
                </h2>
                <div id="collapseFour" class="accordion-collapse collapse" data-bs-parent="#accordionFAQ">
                  <div class="accordion-body">
                    <p>
                      Có thể thanh toán tour bằng tiền mặt, chuyển khoản
                      hoặc thẻ tín dụng.
                    </p>
                    <p>
                      Đối với các tour du lịch trong nước, có thể thanh toán
                      tour trực tiếp tại văn phòng công ty du lịch hoặc qua
                      hình thức chuyển khoản.
                    </p>
                    <p>
                      Đối với các tour du lịch nước ngoài, có thể thanh toán
                      tour qua hình thức chuyển khoản hoặc thẻ tín dụng.
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>

<?php
require_once __DIR__ . '/components/footer.php';
?>