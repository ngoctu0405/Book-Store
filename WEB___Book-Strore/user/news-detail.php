<!-- news-detail.php -->
<!DOCTYPE html>
<html lang="vi">
  <head>
    <meta charset="UTF-8" />
    <title>Chi tiết Tin tức</title>
    <link rel="icon" type="image/jpg" href="../images/Logo_pic_removebg.png" />

    <!-- CSS chính -->
    <link rel="stylesheet" href="../assets/css/style.css" />
    <!-- Bootstrap -->
    <link
      rel="stylesheet"
      href="../bootstrap-5.3.2-dist/css/bootstrap.min.css"
    />

    <style>
      /* Nền & chữ */
      body {
        font-family: "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
        background-color: #f8f9fa;
        color: #333;
        margin: 0;
        padding: 0;
      }

      .container {
        position: relative;
        margin: 4rem auto;
      }

      /* Khung tổng */
      #page {
        position: relative;
        top: 6rem;
        max-width: 900px;
        min-height: 85rem;
        margin: 60px auto;
        background: #fff;
        padding: 40px 50px;
        border-radius: 12px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.08);
        animation: fadeIn 0.6s ease;
      }

      /* Tiêu đề */
      #title {
        font-size: 2rem;
        font-weight: bold;
        color: #222;
        line-height: 1.4;
        border-left: 5px solid #007bff;
        padding-left: 12px;
        margin-bottom: 15px;
      }

      /* Thông tin phụ */
      #meta {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        font-size: 0.95rem;
        color: #777;
        margin-bottom: 20px;
      }

      #category::before {
        content: "📚 ";
      }
      #date::before {
        content: "🗓️ ";
      }
      #author::before {
        content: "✍️ ";
      }

      /* Ảnh chính */
      #image {
        width: 100%;
        height: 44rem;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        margin: 20px 0;
      }

      /* Nội dung bài */
      #content {
        font-size: 1.05rem;
        color: #444;
        text-align: justify;
        white-space: pre-line;
        margin-top: 15px;
        line-height: 1.8;
      }

      /* Nút quay lại */
      #back {
        margin-top: 35px;
        background: #007bff;
        color: #fff;
        text-decoration: none;
        padding: 10px 20px;
        border-radius: 6px;
        transition: 0.25s ease;
      }

      #back:hover {
        background: #0056b3;
        color: #fff;
      }

      /* Hiệu ứng mượt */
      @keyframes fadeIn {
        from {
          opacity: 0;
          transform: translateY(10px);
        }
        to {
          opacity: 1;
          transform: translateY(0);
        }
      }
    </style>
  </head>

  <body>
    <a id="top"></a>

    <!-- HEADER -->
    <header class="topbar">
      <div class="logo">
        <a href="index.php">
          <img class="Logo" src="../images/Logo_removebg.png" alt="Logo" />
          <img
            class="Word"
            src="../images/Logo_word_removebg.png"
            alt="Literary Haven"
          />
        </a>
      </div>

      <div class="auth-cart">
        <div id="authArea">
          <button class="btn-auth" onclick="openLoginModal()">Đăng nhập</button>
          <button class="btn-auth btn-signup" onclick="openRegisterModal()">
            Đăng ký
          </button>
        </div>
      </div>
    </header>

    <!-- NAV -->
    <nav class="navbar" id="mainNav">
      <ul class="menu" id="mainMenu">
        <li><a href="index.php">Trang chủ</a></li>
        <li><a href="about.php">Giới thiệu</a></li>
        <div class="category-menu">
          <button class="category-btn">Danh mục ▾</button>

          <ul class="book-filter">
            <li class="dropdown">
              <a href="category.php?category=Văn học" data-category="Văn học"
                >Văn học ▸</a
              >
              <ul class="dropdown-content">
                <li>
                  <a
                    href="category.php?category=Văn học&subcategory=Tiểu thuyết"
                    >Tiểu thuyết</a
                  >
                </li>
                <li>
                  <a
                    href="category.php?category=Văn học&subcategory=Truyện ngắn"
                    >Truyện ngắn</a
                  >
                </li>
                <li>
                  <a href="category.php?category=Văn học&subcategory=Thơ"
                    >Thơ</a
                  >
                </li>
              </ul>
            </li>

            <li class="dropdown">
              <a href="category.php?category=Kinh tế">Kinh tế ▸</a>
              <ul class="dropdown-content">
                <li>
                  <a href="category.php?category=Kinh tế&subcategory=Quản trị"
                    >Quản trị</a
                  >
                </li>
                <li>
                  <a href="category.php?category=Kinh tế&subcategory=Tài chính"
                    >Tài chính</a
                  >
                </li>
                <li>
                  <a href="category.php?category=Kinh tế&subcategory=Marketing"
                    >Marketing</a
                  >
                </li>
              </ul>
            </li>

            <li class="dropdown">
              <a href="category.php?category=Thiếu nhi">Thiếu nhi ▸</a>
              <ul class="dropdown-content">
                <li>
                  <a
                    href="category.php?category=Thiếu nhi&subcategory=Truyện tranh"
                    >Truyện tranh</a
                  >
                </li>
                <li>
                  <a
                    href="category.php?category=Thiếu nhi&subcategory=Giáo dục"
                    >Giáo dục</a
                  >
                </li>
              </ul>
            </li>

            <li class="dropdown">
              <a href="category.php?category=Giáo khoa">Giáo khoa ▸</a>
              <ul class="dropdown-content">
                <li>
                  <a href="category.php?category=Giáo khoa&subcategory=Cấp 1"
                    >Cấp 1</a
                  >
                </li>
                <li>
                  <a href="category.php?category=Giáo khoa&subcategory=Cấp 2"
                    >Cấp 2</a
                  >
                </li>
                <li>
                  <a href="category.php?category=Giáo khoa&subcategory=Cấp 3"
                    >Cấp 3</a
                  >
                </li>
              </ul>
            </li>
          </ul>
        </div>
        <li><a href="news.php">Tin tức</a></li>
      </ul>
    </nav>

    <!-- Tìm kiếm và giỏ hàng -->
    <div class="nav_2">
      <div class="search-center">
        <input
          id="topSearch"
          class="search-input"
          type="text"
          placeholder="Nhập tên cuốn sách bạn đang tìm ..."
          autocomplete="off"
        />
        <button class="search-btn" type="button">Tìm kiếm</button>
      </div>
      <div class="cart-float" id="cartFloat">
        <button id="cartBtnFloat" class="btn">
          <span class="cart-icon">🛒</span>
          <span id="cart-count" class="cart-count">0</span>
        </button>
      </div>
    </div>

    <a id="back" href="index.php">&larr; Quay lại trang chủ</a>
    <div class="container">
      <div id="page">
        <h1 id="title"></h1>

        <div id="meta">
          <span id="category"></span>
          <span id="date"></span>
          <span id="author"></span>
        </div>

        <img id="image" alt="Ảnh bài viết" />

        <p id="content"></p>
      </div>
    </div>

    <script>
      // Lấy ID từ URL (?id=3)
      const params = new URLSearchParams(window.location.search);
      const id = params.get("id");

      // Dữ liệu bài viết
      const newsData = [
        {
          id: "1",
          title: "‘Mãi mãi tuổi hai mươi’ - nhật ký vượt thời gian",
          image: "./images/Mãi mãi tuổi hai mươi.jpg",
          category: "Văn học",
          author: "Nguyễn Văn An",
          date: "05/03/2024",
          content: `
            “Mãi mãi tuổi hai mươi” là cuốn nhật ký xúc động của liệt sĩ Nguyễn Văn Thạc – một sinh viên Hà Nội lên đường ra trận khi tuổi đời còn rất trẻ. Từng dòng chữ trong nhật ký không chỉ ghi lại những suy nghĩ, cảm xúc của một người lính, mà còn là tấm gương phản chiếu cả một thế hệ thanh niên Việt Nam thời chiến – đầy nhiệt huyết, dũng cảm và tình yêu Tổ quốc sâu sắc.

            Cuốn sách không chỉ là bản ghi chép đời thường, mà còn là một tác phẩm văn học đậm tính nhân văn. Nguyễn Văn Thạc viết về đồng đội, về những ngày hành quân trong bom đạn, nhưng giữa khói lửa ấy vẫn luôn hiện lên niềm tin vào tương lai, vào hòa bình, vào tình yêu và tuổi trẻ. Chính sự đối lập giữa chiến tranh và lý tưởng sống đã khiến tác phẩm trở nên mạnh mẽ và chân thật đến nao lòng.

            Từ khi được xuất bản, “Mãi mãi tuổi hai mươi” đã trở thành cuốn sách gối đầu giường của hàng triệu độc giả trẻ. Nhiều người tìm thấy trong đó hình ảnh của chính mình – đang khát vọng sống, đang đấu tranh với những hoài nghi và tìm kiếm giá trị thật của cuộc đời. Sự trong sáng, hồn nhiên nhưng sâu sắc trong từng câu chữ khiến người đọc không thể dửng dưng.

            Không chỉ là câu chuyện cá nhân, cuốn nhật ký còn là lời nhắc nhở về lòng yêu nước, về trách nhiệm và khát vọng cống hiến. Trong xã hội hiện đại, khi nhịp sống nhanh khiến con người đôi khi quên đi những giá trị căn bản, “Mãi mãi tuổi hai mươi” như một ngọn đuốc soi sáng – nhắc ta rằng: sống không chỉ để tồn tại, mà còn để cống hiến.

            Ngày nay, mỗi khi nhắc đến cuốn sách này, người ta không chỉ nhớ đến Nguyễn Văn Thạc, mà còn nhớ đến cả một thế hệ thanh niên Việt Nam anh dũng. Một thế hệ đã sống trọn vẹn với ước mơ, với niềm tin và tình yêu không bao giờ tắt.
                `,
        },
        {
          id: "2",
          title: "Tư Duy Phản Biện Thông Minh – Rèn Kỹ Năng Phân Tích",
          image: "./images/Tư duy phản biện.jpg",
          category: "Phát triển bản thân",
          author: "Lê Thị Minh",
          date: "22/04/2024",
          content: `
            Trong thời đại mà thông tin lan truyền chóng mặt, tư duy phản biện trở thành một trong những kỹ năng sống còn giúp con người không bị “dẫn dắt” bởi dòng chảy thông tin sai lệch. Cuốn “Tư Duy Phản Biện Thông Minh” là cẩm nang dành cho bất kỳ ai muốn rèn luyện khả năng phân tích, đánh giá và ra quyết định một cách sáng suốt.

            Cuốn sách mở đầu bằng những khái niệm nền tảng: thế nào là tư duy phản biện, tại sao nó quan trọng, và làm thế nào để thoát khỏi lối suy nghĩ rập khuôn. Tác giả không chỉ nói về lý thuyết mà còn lồng ghép vô số ví dụ đời thường – từ việc đọc tin tức, trao đổi trên mạng xã hội, đến cách chúng ta phản ứng với những tình huống trong công việc.

            Điều đặc biệt là tác giả chỉ ra rằng tư duy phản biện không phải là “chống đối” hay “hoài nghi mọi thứ”, mà là cách tiếp cận cẩn trọng, trung lập và có cơ sở. Một người có tư duy phản biện tốt không dễ bị thao túng bởi cảm xúc hay định kiến, mà luôn biết đặt câu hỏi “Tại sao lại như vậy?” và “Có bằng chứng nào chứng minh điều này không?”.

            Phần sau của cuốn sách hướng dẫn người đọc thực hành tư duy phản biện trong các lĩnh vực khác nhau: từ việc học tập, ra quyết định tài chính, đến giải quyết mâu thuẫn giữa người với người. Mỗi chương đều kết thúc bằng những bài tập nhỏ giúp người đọc tự kiểm nghiệm và rèn luyện thói quen phân tích.

            Kết thúc tác phẩm, tác giả khẳng định: “Phản biện không chỉ để đúng, mà để hiểu rõ hơn.” Và đó chính là tinh thần mà bất kỳ ai trong thời đại mới cũng cần mang theo – để sống tự chủ, sáng suốt và nhân văn hơn mỗi ngày.
                `,
        },
        {
          id: "3",
          title: "Những cuốn sách mới đáng chú ý nửa cuối 2025",
          image: "./images/Top sách 2025.jpg",
          category: "Văn hóa - Sách",
          author: "Phạm Quốc Huy",
          date: "31/10/2025",
          content: `
            Thị trường sách nửa cuối năm 2025 chứng kiến sự xuất hiện của nhiều tác phẩm đáng chú ý, từ tiểu thuyết, sách phát triển bản thân đến sách nghệ thuật. Một số đầu sách mới đã nhanh chóng thu hút độc giả nhờ nội dung hấp dẫn và chủ đề gần gũi với đời sống hiện đại.

            Trong đó, các tiểu thuyết mang yếu tố tâm lý – xã hội được nhiều bạn trẻ quan tâm, phản ánh cuộc sống và những mối quan hệ trong thời đại số. Bên cạnh đó, các sách self-help và kỹ năng mềm vẫn tiếp tục được độc giả săn đón, đặc biệt là các cuốn hướng đến cách quản lý thời gian, tài chính cá nhân và phát triển sự nghiệp.

            Xu hướng đọc sách điện tử và audiobook tiếp tục tăng, giúp độc giả dễ dàng tiếp cận các tác phẩm mới mọi lúc, mọi nơi. Nhiều nhà xuất bản cũng tổ chức các buổi ra mắt sách trực tuyến, kết hợp giao lưu với tác giả, tạo trải nghiệm mới mẻ cho người đọc.

            Không chỉ là thị trường giải trí, sách năm 2025 còn trở thành cầu nối tri thức, khuyến khích độc giả tìm kiếm cảm hứng và phát triển bản thân. Những tác phẩm sáng tạo, dễ tiếp cận và có thông điệp tích cực đang chiếm ưu thế, hứa hẹn là lựa chọn hấp dẫn cho mùa đọc cuối năm.
          `,
        },

        {
          id: "4",
          title: "Phong trào đọc sách đang quay trở lại mạnh mẽ",
          image: "./images/Phong trào đọc sách.jpg",
          category: "Văn hóa đọc",
          author: "Trần Ngọc Lan",
          date: "12/11/2024",
          content: `
            Những năm gần đây, khi mạng xã hội chiếm phần lớn thời gian của giới trẻ, nhiều người từng lo ngại rằng thói quen đọc sách đang dần biến mất. Tuy nhiên, thực tế cho thấy điều ngược lại: phong trào đọc sách đang quay trở lại mạnh mẽ hơn bao giờ hết, đặc biệt là trong thế hệ Gen Z.

            Tại các thành phố lớn, hàng loạt quán cà phê sách, câu lạc bộ đọc, và hội nhóm chia sẻ review sách mọc lên như nấm. Những “book influencer” trên TikTok, YouTube hay Instagram trở thành cầu nối mới giữa sách và người đọc, truyền cảm hứng bằng những video ngắn nhưng đầy cảm xúc.

            Không chỉ dừng ở việc đọc, giới trẻ còn có xu hướng “sống cùng sách” – họ chia sẻ suy nghĩ, thậm chí sáng tạo nội dung dựa trên tác phẩm mình yêu thích. Các nhà xuất bản cũng nhanh chóng nắm bắt xu hướng này, tạo ra những ấn phẩm có thiết kế hiện đại, phù hợp thị hiếu và mang thông điệp tích cực.

            Một điểm đáng chú ý là độc giả hiện đại không còn giới hạn ở thể loại văn học truyền thống. Họ quan tâm đến sách kỹ năng, triết học ứng dụng, tâm lý học và cả những cuốn sách khoa học phổ thông. Điều đó cho thấy nhu cầu học hỏi và phát triển bản thân vẫn luôn hiện hữu, chỉ là cách tiếp cận đã thay đổi.

            Nhìn chung, sự trở lại của văn hóa đọc không chỉ là xu hướng, mà còn là tín hiệu đáng mừng cho xã hội – nơi con người tìm lại sự tĩnh lặng giữa nhịp sống số hóa, và để tri thức một lần nữa trở thành sức mạnh lan tỏa bền vững.
                `,
        },
        {
          id: "5",
          title: "Talkshow cuối năm: Hành trình tới sao Hỏa & tương lai",
          image: "./images/Talk show.png",
          category: "Khoa học - Công nghệ",
          author: "Ngô Thanh Tùng",
          date: "29/12/2024",
          content: `
            Talkshow “Hành trình tới sao Hỏa” được tổ chức tại TP.HCM thu hút hàng nghìn người tham dự, từ sinh viên, nhà nghiên cứu đến những người yêu khoa học. Chương trình được dẫn dắt bởi các chuyên gia hàng đầu trong lĩnh vực công nghệ hàng không và triết học không gian, mang đến cái nhìn toàn diện về tương lai chinh phục vũ trụ của nhân loại.

            Mở đầu sự kiện, diễn giả chia sẻ về lịch sử khám phá sao Hỏa – từ những sứ mệnh đầu tiên của NASA cho đến kế hoạch xây dựng căn cứ sinh sống của SpaceX. Người nghe không chỉ được tiếp cận thông tin kỹ thuật, mà còn được khơi dậy niềm tin và trí tưởng tượng về khả năng sinh tồn ngoài Trái Đất.

            Điểm nhấn của talkshow là phần thảo luận mở: “Liệu con người có nên rời bỏ Trái Đất?”. Nhiều quan điểm được đưa ra – có người cho rằng đó là bước tiến tất yếu, người khác lại lo ngại về hệ quả đạo đức và môi trường. Sự tranh luận sôi nổi khiến khán phòng không lúc nào ngớt tiếng vỗ tay.

            Ngoài khoa học, chương trình còn gợi mở những câu hỏi nhân văn: nếu một ngày ta sống trên hành tinh khác, ta có còn giữ được bản sắc, ký ức và cảm xúc của loài người không? Câu hỏi ấy khiến nhiều người trăn trở và nhận ra rằng – hành trình khám phá vũ trụ cũng là hành trình khám phá chính mình.

            Kết thúc talkshow, thông điệp “Đi xa để hiểu mình hơn” vang vọng trong lòng khán giả. Không chỉ là tri thức khoa học, đó là lời nhắc về khát vọng và trách nhiệm – rằng dù ở hành tinh nào, con người vẫn cần giữ gìn tình yêu, lòng nhân ái và sự tò mò bất tận.
                `,
        },
        {
          id: "6",
          title: "Hội sách mùa hè 2024 – Kết nối tri thức",
          image: "./images/Hội sách.jpg",
          category: "Sự kiện",
          author: "Vũ Hải Yến",
          date: "10/06/2024",
          content: `
            Hội sách mùa hè 2024 diễn ra tại Nhà văn hóa Thanh Niên TP.HCM đã trở thành điểm hẹn quen thuộc của những người yêu sách. Sự kiện quy tụ hơn 50 nhà xuất bản và hàng chục ngàn đầu sách thuộc đủ mọi thể loại, từ văn học, khoa học, đến thiếu nhi và kỹ năng sống.

            Không khí hội sách vô cùng sôi động với hàng trăm lượt người ra vào mỗi ngày. Bên cạnh các gian hàng bán sách giảm giá, khu vực “Đổi sách – Nhận tri thức” được độc giả đặc biệt yêu thích. Ở đó, người tham dự có thể mang sách cũ của mình đến đổi lấy sách mới, vừa tiết kiệm vừa góp phần lan tỏa văn hóa đọc xanh.

            Ngoài hoạt động mua bán, hội sách còn có nhiều buổi tọa đàm thú vị với sự tham gia của các tác giả nổi tiếng như Nguyễn Nhật Ánh, Trần Đăng Khoa và nhà báo Trác Thúy Miêu. Các buổi trò chuyện không chỉ xoay quanh tác phẩm, mà còn bàn về hành trình viết, cảm hứng sáng tạo và những trăn trở trong nghề cầm bút.

            Đặc biệt, khu vực dành cho trẻ em với chủ đề “Khám phá thế giới bằng trang sách” thu hút hàng nghìn em nhỏ cùng phụ huynh. Các trò chơi tương tác, vẽ tranh theo truyện, và kể chuyện bằng tranh đã giúp các bé hình thành tình yêu với sách từ rất sớm.

            Kết thúc hội sách, ban tổ chức nhận được hàng chục nghìn lượt phản hồi tích cực. Rõ ràng, giữa kỷ nguyên số, sách vẫn giữ được vị trí đặc biệt – là cầu nối tri thức và cảm xúc giữa con người với con người.
                `,
        },
        {
          id: "7",
          title:
            "Ra mắt bộ sách mới “Hành Trình Tri Thức 2025” thu hút độc giả trẻ",
          image: "./images/Hành trình tri thức.jpg",
          category: "Văn hóa - Sách",
          author: "Nguyễn Minh Tâm",
          date: "28/10/2025",
          content: `
            Mới đây, tại Hà Nội, nhà xuất bản Tri Thức Việt đã tổ chức lễ ra mắt bộ sách “Hành Trình Tri Thức 2025”, thu hút đông đảo độc giả, đặc biệt là giới trẻ. Bộ sách tập hợp các đầu sách về kỹ năng sống, tư duy sáng tạo, và phát triển bản thân, được biên soạn bởi nhiều tác giả nổi tiếng trong nước.

            Sự kiện không chỉ giới thiệu sách mà còn tổ chức các buổi giao lưu, ký tặng sách với tác giả, workshop chia sẻ kinh nghiệm đọc sách hiệu quả và ứng dụng kiến thức vào cuộc sống. Nhiều độc giả cho biết họ bị ấn tượng bởi nội dung dễ hiểu, sinh động và thực tiễn của bộ sách, phù hợp với nhu cầu tự học và phát triển bản thân hiện nay.

            Đây cũng là nỗ lực của nhà xuất bản trong việc khuyến khích văn hóa đọc, đặc biệt trong bối cảnh người trẻ Việt Nam ngày càng quan tâm tới việc nâng cao tri thức và kỹ năng mềm. Bộ sách dự kiến sẽ được phân phối rộng rãi trên toàn quốc, bao gồm cả các nền tảng sách điện tử, giúp mọi độc giả dễ dàng tiếp cận.

            Với thông điệp “Học mỗi ngày – Trưởng thành mỗi bước”, bộ sách hứa hẹn trở thành người bạn đồng hành lý tưởng cho những ai muốn phát triển toàn diện trong năm 2025.
                `,
        },

        {
          id: "8",
          title: "Workshop: Sáng tạo trong công nghệ & xu hướng mới",
          image: "./images/Work shop.jpg",
          category: "Công nghệ",
          author: "Trương Bảo Minh",
          date: "05/05/2024",
          content: `
            Workshop “Sáng tạo trong công nghệ” diễn ra tại Đại học Bách Khoa đã thu hút hơn 500 sinh viên và chuyên gia trẻ tham gia. Chủ đề chính năm nay tập trung vào trí tuệ nhân tạo, thực tế mở rộng (XR), và xu hướng sáng tạo đa ngành trong phát triển sản phẩm công nghệ.

            Diễn giả mở đầu bằng câu hỏi: “Sáng tạo là gì trong thời đại AI?” – câu hỏi tưởng chừng đơn giản nhưng khiến cả khán phòng im lặng. Khi máy móc ngày càng thông minh, vai trò của con người không còn là thực hiện lặp lại, mà là đặt ra những câu hỏi mới, định hình cách AI phục vụ cho lợi ích chung.

            Phần nổi bật nhất của sự kiện là thử thách “Hackathon Mini” – nơi các nhóm sinh viên phải xây dựng ý tưởng ứng dụng công nghệ chỉ trong 48 giờ. Từ dự án robot hỗ trợ người khuyết tật, đến nền tảng giáo dục trực tuyến cá nhân hóa bằng AI, hàng chục ý tưởng xuất sắc đã ra đời ngay tại hội trường.

            Ngoài ra, workshop còn nhấn mạnh đến khía cạnh đạo đức của công nghệ. Làm sao để AI không vượt khỏi tầm kiểm soát con người? Làm sao để sáng tạo vẫn gắn liền với trách nhiệm xã hội? Những câu hỏi ấy khiến buổi thảo luận trở nên sâu sắc và đáng suy ngẫm.

            Kết thúc chương trình, nhiều dự án được chọn để ươm mầm tại các trung tâm khởi nghiệp. Hơn cả một sự kiện, workshop đã chứng minh rằng công nghệ và sáng tạo chỉ thật sự có ý nghĩa khi nó giúp thế giới tốt đẹp hơn từng chút một.
                `,
        },
        {
          id: "9",
          title: "Literary Haven khai trương showroom mới tại TP.HCM",
          image: "./images/Literary haven.jpg",
          category: "Tin tức",
          author: "Các nhà phát triển của Literary Haven",
          date: "01/11/2025",
          content: `
    Literary Haven chính thức khai trương showroom mới tại TP.HCM, đánh dấu một bước tiến quan trọng trong hành trình lan tỏa văn hóa đọc đến cộng đồng yêu sách Việt Nam.  

    Với diện tích hơn 500m², showroom được thiết kế theo phong cách hiện đại, mang đến không gian đọc sách thoải mái, gần gũi và đầy cảm hứng. Không chỉ là nơi trưng bày hàng ngàn đầu sách từ khắp nơi trên thế giới, đây còn là điểm đến lý tưởng để độc giả trải nghiệm, giao lưu và chia sẻ niềm đam mê với sách.

    Khu vực đọc mở, ánh sáng tự nhiên cùng những góc decor tinh tế giúp người đọc cảm nhận sự yên tĩnh và thư giãn trọn vẹn. Ngoài ra, showroom còn có khu vực cà phê sách và không gian dành riêng cho các buổi ra mắt, ký tặng và tọa đàm cùng tác giả.

    Sự kiện khai trương đã thu hút đông đảo độc giả, nhà xuất bản và người yêu văn hóa đọc đến tham quan và trải nghiệm. Literary Haven kỳ vọng showroom mới tại TP.HCM sẽ trở thành điểm hẹn quen thuộc của những tâm hồn yêu sách, góp phần thúc đẩy thói quen đọc và lan tỏa tri thức trong cộng đồng.

    Hãy đến và khám phá không gian sách hiện đại này — nơi mỗi trang sách đều mở ra một hành trình mới của tri thức và cảm xúc.
  `,
        },
        {
          id: "10",
          title: "Top 10 cuốn sách bán chạy nhất tháng 10",
          image: "./images/Top sách tháng 10.jpg",
          category: "📖 Sách mới",
          author: "Ban biên tập Literary Haven",
          date: "08/10/2025",
          content: `
    Tháng 10 vừa qua, Literary Haven ghi nhận danh sách 10 tựa sách được độc giả yêu thích và săn đón nhiều nhất. Những cuốn sách này không chỉ mang đến kiến thức và cảm hứng, mà còn phản ánh xu hướng đọc đang thịnh hành tại Việt Nam.  

    Từ các tác phẩm văn học sâu sắc đến những đầu sách kinh tế và phát triển bản thân, top 10 tháng này là minh chứng cho sự đa dạng trong lựa chọn của độc giả.  

    📚 **Top 10 cuốn sách bán chạy nhất tháng 10:**  
    1. *Đắc Nhân Tâm* – Dale Carnegie  
    2. *Nhà Giả Kim* – Paulo Coelho  
    3. *Tư Duy Nhanh Và Chậm* – Daniel Kahneman  
    4. *Trên Đường Băng* – Tony Buổi Sáng  
    5. *Sức Mạnh Của Thói Quen* – Charles Duhigg  
    6. *Cà Phê Cùng Tony* – Tony Buổi Sáng  
    7. *7 Thói Quen Hiệu Quả* – Stephen R. Covey  
    8. *Không Gia Đình* – Hector Malot  
    9. *Bí Mật Của May Mắn* – Álex Rovira & Fernando Trías de Bes  
    10. *Muôn Kiếp Nhân Sinh* – Nguyên Phong  

    Những tựa sách này tiếp tục khẳng định sức hút bền vững với độc giả ở mọi lứa tuổi.  
    Nếu bạn đang tìm kiếm cuốn sách để khởi đầu tháng mới, danh sách trên chắc chắn sẽ là nguồn cảm hứng tuyệt vời.
  `,
        },
        {
          id: "11",
          title: "Gặp gỡ tác giả Nguyễn Nhật Ánh",
          image: "./images/Nguyễn Nhật Ánh.jpg",
          category: "✍️ Tác giả",
          author: "Ban tổ chức Literary Haven",
          date: "05/10/2025",
          content: `
    Literary Haven hân hạnh thông báo sự kiện đặc biệt dành cho người yêu sách: **Gặp gỡ và ký tặng cùng nhà văn Nguyễn Nhật Ánh** – một trong những tác giả được yêu mến nhất của văn học Việt Nam.  

    📅 **Thời gian:** Ngày 15/10/2025  
    📍 **Địa điểm:** Showroom Literary Haven, TP.HCM  

    Đây là cơ hội hiếm có để độc giả được trực tiếp gặp gỡ, giao lưu và lắng nghe những chia sẻ chân thành từ “người kể chuyện tuổi thơ” Nguyễn Nhật Ánh – tác giả của hàng loạt tác phẩm nổi tiếng như *Tôi Thấy Hoa Vàng Trên Cỏ Xanh*, *Cho Tôi Xin Một Vé Đi Tuổi Thơ*, *Ngồi Khóc Trên Cây*…  

    Trong buổi gặp gỡ, nhà văn sẽ chia sẻ về hành trình sáng tác, cảm hứng đằng sau những câu chuyện chạm đến trái tim hàng triệu độc giả, cũng như ký tặng sách và chụp ảnh lưu niệm cùng fan hâm mộ.  

    Số lượng chỗ ngồi có hạn, vì vậy hãy đăng ký sớm để không bỏ lỡ cơ hội đặc biệt này.  
    Cùng đến và cảm nhận không khí ấm áp, gần gũi – nơi những câu chuyện tuổi thơ được kể lại bằng tất cả sự chân thành và yêu thương.
  `,
        },
        {
          id: "12",
          title: "Giảm giá 30% toàn bộ sách kinh tễ",
          image: "./images/Sách kinh tế.jpg",
          category: "🎁 Khuyến mãi",
          author: "Literary Haven",
          date: "03/10/2025",
          content: `
    Tin vui dành cho những ai yêu thích sách về **kinh tế, kinh doanh và quản trị**!  
    Từ ngày **05/10 đến 20/10/2025**, Literary Haven triển khai chương trình **giảm giá 30% toàn bộ sách kinh tế**, áp dụng tại cả showroom TP.HCM và hệ thống bán hàng trực tuyến.  

    Đây là dịp đặc biệt để bạn sở hữu những cuốn sách đã và đang làm thay đổi tư duy hàng triệu người: từ các tác phẩm kinh điển như *Tư Duy Nhanh Và Chậm*, *Cha Giàu Cha Nghèo*, *Bí Mật Tư Duy Triệu Phú*, cho đến những đầu sách hiện đại giúp phát triển kỹ năng lãnh đạo, đầu tư và khởi nghiệp.  

    🎯 **Chi tiết chương trình:**  
    - Giảm 30% cho toàn bộ danh mục sách kinh tế, quản trị, tài chính, marketing và khởi nghiệp.  
    - Áp dụng tại showroom Literary Haven và website chính thức.  
    - Khách hàng thành viên được **tặng thêm voucher 10%** cho đơn hàng tiếp theo.  
    - Mỗi đơn hàng trên 500.000đ được **miễn phí vận chuyển toàn quốc**.  

    Không chỉ là ưu đãi mua sắm, đây còn là lời mời gọi bạn đầu tư cho bản thân – bởi tri thức chính là tài sản bền vững nhất.  
    Hãy nhanh tay chọn cho mình những cuốn sách yêu thích và bắt đầu hành trình phát triển tư duy tài chính cùng Literary Haven hôm nay!
  `,
        },
        {
          id: "13",
          title: 'Review: "Đắc Nhân Tâm" - Cuốn sách không bao giờ cũ',
          image: "./images/Review.jpg",
          category: "⭐ Review",
          author: "Ngọc Minh",
          date: "01/10/2025",
          content: `
    Sau gần một thế kỷ kể từ khi ra đời, *Đắc Nhân Tâm* của **Dale Carnegie** vẫn là cuốn sách gối đầu giường của hàng triệu người trên thế giới.  
    Dù xã hội thay đổi, những bài học trong cuốn sách này vẫn giữ nguyên giá trị – bởi chúng chạm đến cốt lõi của giao tiếp, ứng xử và thấu hiểu con người.  

    Tác phẩm không chỉ dạy cách “làm người khác thích mình”, mà còn là kim chỉ nam giúp ta biết **lắng nghe, tôn trọng và đồng cảm** hơn trong mọi mối quan hệ.  
    Mỗi trang sách đều gợi mở những nguyên tắc ứng xử tinh tế, giúp bạn phát triển bản thân, xây dựng niềm tin và gây ảnh hưởng một cách chân thành.

    Dù bạn là sinh viên, người đi làm hay nhà lãnh đạo, *Đắc Nhân Tâm* luôn mang lại giá trị mới mỗi khi đọc lại.  
    Một cuốn sách “không bao giờ cũ” – bởi nó nói về điều muôn thuở: **nghệ thuật thấu hiểu con người.**
  `,
        },

        {
          id: "14",
          title: "Hội sách mùa thu 2025",
          image: "./images/Hội sách mùa thu.jpg",
          category: "🎪 Sự kiện",
          author: "Ban tổ chức Literary Haven",
          date: "28/09/2025",
          content: `
    Hội sách mùa thu 2025 chính thức trở lại với quy mô lớn nhất từ trước đến nay!  
    Sự kiện quy tụ **hàng trăm gian hàng** từ các nhà xuất bản và thương hiệu sách hàng đầu, cùng hàng loạt hoạt động văn hóa hấp dẫn dành cho độc giả mọi lứa tuổi.  

    🌟 **Điểm nhấn của hội sách:**  
    - Giảm giá đến **50%** cho hàng ngàn đầu sách.  
    - Giao lưu cùng các tác giả nổi tiếng.  
    - Khu vực trưng bày sách hiếm và góc đọc mở.  
    - Workshop và minigame với nhiều phần quà hấp dẫn.  

    📅 **Thời gian:** 01/10 – 05/10/2025  
    📍 **Địa điểm:** Công viên Văn Lang, TP.HCM  

    Hãy cùng hòa mình vào không gian văn hóa đọc đầy sắc màu và tìm cho mình những cuốn sách yêu thích nhất tại **Hội sách mùa thu 2025**!
  `,
        },

        {
          id: "15",
          title: "5 cách giúp bạn đọc nhiều sách hơn",
          image: "./images/Cách đọc sách.jpeg",
          category: "💡 Mẹo hay",
          author: "Trần Bảo Linh",
          date: "25/09/2025",
          content: `
    Đọc sách là thói quen tuyệt vời – nhưng không phải ai cũng dễ duy trì nó giữa nhịp sống bận rộn.  
    Dưới đây là **5 mẹo nhỏ** giúp bạn biến việc đọc sách thành một phần tự nhiên trong cuộc sống hàng ngày:  

    1. 📆 **Đặt mục tiêu nhỏ mỗi ngày:** chỉ cần 10-15 phút đọc mỗi buổi sáng hoặc tối.  
    2. 📚 **Mang theo sách bên mình:** tranh thủ đọc khi chờ xe, uống cà phê hay nghỉ trưa.  
    3. 📱 **Sử dụng audiobook hoặc e-book:** tiện lợi cho những người thường xuyên di chuyển.  
    4. ✍️ **Ghi chú và chia sẻ cảm nhận:** giúp ghi nhớ nội dung và tạo cảm hứng tiếp tục đọc.  
    5. ☕ **Tạo không gian đọc yêu thích:** một góc yên tĩnh, ánh sáng tốt và tách trà ấm sẽ khiến bạn muốn mở sách mỗi ngày.  

    Hãy bắt đầu từ những trang đầu tiên – vì mỗi cuốn sách đều có thể mở ra một thế giới mới cho bạn.
  `,
        },
      ];

      // Tìm bài viết theo ID
      const news = newsData.find((n) => n.id === id);

      if (news) {
        document.getElementById("title").innerText = news.title;
        document.getElementById("image").src = news.image;
        document.getElementById("content").innerText = news.content;
        document.getElementById("author").innerText = news.author;
        document.getElementById("date").innerText = news.date;
        document.getElementById("category").innerText = news.category;
      } else {
        document.getElementById("title").innerText = "Không tìm thấy bài viết!";
      }
    </script>
    <a href="#" class="back-to-top" title="Lên đầu trang">
      <i class="bi bi-chevron-up">
        <img class="go-up" src="../images/muiten.svg" alt="Về trang chủ" />
      </i>
    </a>
    <footer>
      <div class="footer-content">
        <div class="footer-section">
          <h3>Về Chúng tôi</h3>
          <ul>
            <li><a href="about.php">Giới thiệu</a></li>
            <li><a href="./news.php">Tin tức</a></li>
            <li><a href="./privacy_policy.php">Chính sách bảo mật</a></li>
            <li><a href="./terms-of-use.php">Điều khoản sử dụng</a></li>
          </ul>
        </div>

        <div class="footer-section">
          <h3>Hỗ trợ khách hàng</h3>
          <ul>
            <li><a href="./shopping_guide.php">Hướng dẫn mua hàng</a></li>
            <li><a href="./exchange-policy.php">Chính sách đổi trả</a></li>
            <li><a href="./warranty-policy.php">Chính sách bảo hành</a></li>
            <li>
              <a href="./frequently-asked-questions.php">Câu hỏi thường gặp</a>
            </li>
          </ul>
        </div>

        <div class="footer-section">
          <h3>Chính sách</h3>
          <ul>
            <li><a href="./payment-policy.php">Chính sách thanh toán</a></li>
            <li><a href="./shipping-policy.php">Chính sách vận chuyển</a></li>
            <li><a href="./warranty-policy.php">Chính sách bảo hành</a></li>
            <li><a href="./exchange-policy.php">Chính sách đổi trả</a></li>
          </ul>
        </div>

        <div class="footer-section contact-info">
          <h3>Liên hệ</h3>
          <p>📍 123 Nguyễn Văn Linh, Q7, TP.HCM</p>
          <p>📞 Hotline: 1900 xxxx</p>
          <p>✉️ Email: support@bookstore.vn</p>
          <p>🕐 Giờ làm việc: 8:00 - 22:00</p>
        </div>
      </div>

      <div class="footer-bottom">
        <p>&copy; 2025 Book Store. All rights reserved. | Designed with ❤️</p>
      </div>
    </footer>
    <!-- Modal Đăng Nhập -->
    <div id="loginModal" class="auth-modal">
      <div class="auth-modal-overlay" onclick="closeLoginModal()"></div>
      <div class="auth-modal-content">
        <button class="auth-modal-close" onclick="closeLoginModal()">
          &times;
        </button>

        <div class="auth-modal-header">
          <h2>Đăng Nhập</h2>
          <p>Chào mừng bạn trở lại!</p>
        </div>

        <form id="login-form" class="auth-modal-form">
          <div class="form-group">
            <label for="login-username">Tài khoản</label>
            <div class="input-with-icon">
              <span class="input-icon">👤</span>
              <input
                type="text"
                id="login-username"
                placeholder="Nhập tài khoản"
              />
            </div>
            <span id="error-login-username" class="error-msg"></span>
          </div>

          <div class="form-group">
            <label for="login-password">Mật khẩu</label>
            <div class="input-with-icon">
              <span class="input-icon">🔐</span>
              <input
                type="password"
                id="login-password"
                placeholder="Nhập mật khẩu"
              />
              <span
                class="password-toggle"
                id="toggle-login-password"
                onclick="togglePassword('login-password', 'toggle-login-password')"
                >👁️‍🗨️</span
              >
            </div>
            <span id="error-login-password" class="error-msg"></span>
          </div>

          <button type="submit" class="btn-auth-submit">Đăng Nhập</button>
        </form>

        <div class="auth-modal-footer">
          Chưa có tài khoản?
          <a href="#" onclick="switchToRegister()">Đăng ký ngay</a>
        </div>
      </div>
    </div>

    <!-- Modal Đăng Ký -->
    <div id="registerModal" class="auth-modal">
      <div class="auth-modal-overlay" onclick="closeRegisterModal()"></div>
      <div class="auth-modal-content">
        <button class="auth-modal-close" onclick="closeRegisterModal()">
          &times;
        </button>

        <div class="auth-modal-header">
          <h2>Đăng Ký</h2>
          <p>Tạo tài khoản mới của bạn</p>
        </div>

        <form
          id="register-form"
          class="auth-modal-form"
          style="max-height: 450px; overflow-y: auto"
        >
          <div class="form-group">
            <label for="reg-fullname">Họ và tên</label>
            <div class="input-with-icon">
              <span class="input-icon">👤</span>
              <input
                type="text"
                id="reg-fullname"
                placeholder="Nhập họ và tên"
              />
            </div>
            <span id="error-fullname" class="error-msg"></span>
          </div>

          <div class="form-group">
            <label for="reg-username">Tên tài khoản</label>
            <div class="input-with-icon">
              <span class="input-icon">🔑</span>
              <input
                type="text"
                id="reg-username"
                placeholder="Nhập tên tài khoản"
              />
            </div>
            <span id="error-username" class="error-msg"></span>
          </div>

          <div class="form-group">
            <label for="reg-password">Mật khẩu</label>
            <div class="input-with-icon">
              <span class="input-icon">🔐</span>
              <input
                type="password"
                id="reg-password"
                placeholder="Nhập mật khẩu"
              />
              <span
                class="password-toggle"
                id="toggle-reg-password"
                onclick="togglePassword('reg-password', 'toggle-reg-password')"
                >👁️‍🗨️</span
              >
            </div>
            <span id="error-password" class="error-msg"></span>
          </div>

          <div class="form-group">
            <label for="reg-confirm-password">Nhập lại mật khẩu</label>
            <div class="input-with-icon">
              <span class="input-icon">🔐</span>
              <input
                type="password"
                id="reg-confirm-password"
                placeholder="Nhập lại mật khẩu"
              />
              <span
                class="password-toggle"
                id="toggle-reg-confirm"
                onclick="togglePassword('reg-confirm-password', 'toggle-reg-confirm')"
                >👁️‍🗨️</span
              >
            </div>
            <span id="error-confirm-password" class="error-msg"></span>
          </div>

          <div class="form-group">
            <label for="reg-email">Email</label>
            <div class="input-with-icon">
              <span class="input-icon">📧</span>
              <input type="email" id="reg-email" placeholder="Nhập email" />
            </div>
            <span id="error-email" class="error-msg"></span>
          </div>

          <div class="form-group">
            <label for="reg-phone">Số điện thoại</label>
            <div class="input-with-icon">
              <span class="input-icon">📱</span>
              <input
                type="tel"
                id="reg-phone"
                placeholder="Nhập số điện thoại"
              />
            </div>
            <span id="error-phone" class="error-msg"></span>
          </div>

          <div class="form-group">
            <label for="reg-address">Địa chỉ</label>
            <div class="input-with-icon">
              <span class="input-icon">📍</span>
              <input type="text" id="reg-address" placeholder="Nhập địa chỉ" />
            </div>
            <span id="error-address" class="error-msg"></span>
          </div>

          <button type="submit" class="btn-auth-submit">Đăng Ký</button>
        </form>

        <div class="auth-modal-footer">
          Đã có tài khoản? <a href="#" onclick="switchToLogin()">Đăng nhập</a>
        </div>
      </div>
    </div>

    <!-- Modal Profile (Hiển thị khi đã đăng nhập) -->
    <div id="profileModal" class="auth-modal">
      <div class="auth-modal-overlay" onclick="closeProfileModal()"></div>
      <div class="auth-modal-content">
        <button class="auth-modal-close" onclick="closeProfileModal()">
          &times;
        </button>

        <div class="auth-modal-header">
          <div class="profile-avatar-small">👤</div>
          <h2 id="profile-fullname">Xin chào!</h2>
          <p>Thông tin tài khoản của bạn</p>
        </div>

        <div class="profile-info-modal">
          <div class="info-row">
            <span class="info-label">👤 Họ và tên:</span>
            <span class="info-value" id="profile-name-value"></span>
          </div>
          <div class="info-row">
            <span class="info-label">🔐 Tài khoản:</span>
            <span class="info-value" id="profile-username-value"></span>
          </div>
          <div class="info-row">
            <span class="info-label">📧 Email:</span>
            <span class="info-value" id="profile-email-value"></span>
          </div>
          <div class="info-row">
            <span class="info-label">📱 Số điện thoại:</span>
            <span class="info-value" id="profile-phone-value"></span>
          </div>
          <div class="info-row">
            <span class="info-label">📍 Địa chỉ:</span>
            <span class="info-value" id="profile-address-value"></span>
          </div>
        </div>

        <button class="btn-logout-modal" onclick="handleLogoutModal()">
          Đăng xuất
        </button>
      </div>
    </div>
    <!-- JS -->
    <script src="../assets/js/main.js"></script>
    <script src="../bootstrap-5.3.2-dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
