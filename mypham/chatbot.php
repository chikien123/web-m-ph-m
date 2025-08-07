<?php
header('Content-Type: application/json');

// Đọc nội dung JSON gửi từ JS
$rawData = file_get_contents("php://input");
$data = json_decode($rawData, true);

// Kiểm tra dữ liệu hợp lệ
if (!isset($data['message']) || empty(trim($data['message']))) {
    echo json_encode(["reply" => "Xin vui lòng nhập nội dung câu hỏi."]);
    exit;
}
$question = strtolower(trim($data['message']));

// Trả lời mẫu (nếu không có OpenAI)
$answers = [
    'retinol' => 'Retinol giúp giảm mụn, chống lão hoá. Nên dùng cách ngày và chống nắng kỹ.',
    'ship' => 'Shop hỗ trợ freeship toàn quốc cho đơn hàng từ 499.000đ.',
    'đổi trả' => 'Bạn có thể đổi trả trong vòng 7 ngày nếu sản phẩm còn nguyên tem và chưa sử dụng.',
    'ưu đãi' => 'Hiện tại đang có ưu đãi -30% cho các dòng serum và tẩy trang.',

  // ❣️ Tư vấn sản phẩm
  'kem dưỡng' => 'Chúng tôi có nhiều loại kem dưỡng phù hợp từng loại da như da khô, da dầu, da nhạy cảm. Bạn vui lòng cho biết loại da của bạn để mình tư vấn phù hợp nhé.',
  'sữa rửa mặt' => 'Bạn có thể chọn sữa rửa mặt dịu nhẹ nếu da nhạy cảm, hoặc có salicylic acid nếu bạn đang bị mụn.',
  'serum' => 'Serum B3 giúp sáng da, B5 phục hồi, còn vitamin C giúp làm đều màu và chống lão hoá.',
  'chống nắng' => 'Kem chống nắng vật lý phù hợp da nhạy cảm, còn kem chống nắng hoá học thường thẩm thấu nhanh, nhẹ mặt.',
  'mặt nạ' => 'Chúng tôi có mặt nạ đất sét, mặt nạ dưỡng ẩm và mặt nạ làm sáng da từ thiên nhiên.',
  'tẩy trang' => 'Nước tẩy trang dịu nhẹ phù hợp với mọi loại da, đặc biệt là da nhạy cảm. Dầu tẩy trang phù hợp da khô.',
  'trị mụn' => 'Bạn nên dùng serum BHA hoặc chấm mụn có chứa tea tree oil và giữ da luôn sạch sẽ.',
  'da khô' => 'Với da khô, bạn nên dùng kem dưỡng có thành phần HA và ceramide để giữ ẩm sâu cho da.',
  'da dầu' => 'Bạn nên dùng sản phẩm không chứa dầu (oil-free), kiềm dầu như gel dưỡng hoặc sữa rửa mặt dịu nhẹ.',
  'làm trắng da' => 'Bạn có thể tham khảo serum vitamin C hoặc niacinamide để giúp da đều màu và sáng hơn.',
  'da nhạy cảm' => 'Nên chọn sản phẩm không mùi, không cồn, bảng thành phần ngắn và lành tính như rau má, yến mạch.',
  'nám' => 'Bạn có thể dùng serum vitamin C, arbutin hoặc niacinamide để hỗ trợ giảm nám. Nhớ chống nắng đầy đủ nhé.',
  'mờ thâm' => 'Vitamin C, B3 và AHA/BHA giúp giảm thâm mụn hiệu quả. Có thể dùng serum mỗi tối sau rửa mặt.',
  
  // 🧾 Câu hỏi về đơn hàng
  'tôi đã đặt hàng chưa' => 'Bạn vui lòng đăng nhập và vào trang "Đơn hàng của tôi" để kiểm tra thông tin đặt hàng nhé.',
  'đơn hàng của tôi đâu' => 'Vui lòng đăng nhập tài khoản và kiểm tra trạng thái đơn hàng trong mục "Đơn hàng".',
  'thanh toán thế nào' => 'Hiện tại bạn có thể thanh toán khi nhận hàng (COD). Các phương thức online sẽ cập nhật sau.',
  'bao giờ giao hàng' => 'Thời gian giao hàng trung bình từ 2–4 ngày tuỳ khu vực. Chúng tôi sẽ liên hệ khi giao hàng.',
  'phí vận chuyển' => 'Phí vận chuyển sẽ được tính tự động ở bước thanh toán, tuỳ vào khu vực bạn sinh sống.',
  'tôi muốn hủy đơn' => 'Vui lòng liên hệ bộ phận hỗ trợ hoặc vào phần đơn hàng để hủy nếu đơn chưa được giao.',

  // 🛒 Chức năng web
  'làm sao thêm vào giỏ hàng' => 'Bạn chỉ cần nhấn nút "Thêm vào giỏ" dưới mỗi sản phẩm là sẽ được thêm vào giỏ hàng.',
  'giỏ hàng ở đâu' => 'Bạn có thể thấy biểu tượng giỏ hàng ở góc trên cùng bên phải trang web.',
  'đăng ký thế nào' => 'Bạn vào mục "Đăng ký" ở thanh menu, nhập thông tin cá nhân là có thể tạo tài khoản mới.',
  'quên mật khẩu' => 'Hiện hệ thống chưa hỗ trợ lấy lại mật khẩu tự động. Vui lòng liên hệ chúng tôi để được hỗ trợ.',
  'đăng nhập không được' => 'Vui lòng kiểm tra lại email, mật khẩu và đảm bảo không bật Caps Lock.',
  'đăng xuất ở đâu' => 'Sau khi đăng nhập, bạn sẽ thấy nút "Đăng xuất" ở góc trên bên phải. Nhấn để thoát tài khoản.',

  // 📦 Hỗ trợ mua hàng
  'mua ở đâu' => 'Bạn có thể đặt mua trực tiếp tại trang web này. Chỉ cần nhấn "Thêm vào giỏ", sau đó "Thanh toán".',
  'tôi muốn tư vấn' => 'Bạn vui lòng mô tả da của bạn hoặc nhu cầu cụ thể, mình sẽ hỗ trợ chọn sản phẩm phù hợp.',
  'có sản phẩm nào tốt không' => 'Tất cả sản phẩm của chúng tôi đều được chọn lọc kỹ lưỡng, có nguồn gốc rõ ràng và an toàn cho da.',
  'sản phẩm có chính hãng không' => 'Chúng tôi cam kết 100% hàng chính hãng. Nếu phát hiện hàng giả, bạn sẽ được hoàn tiền gấp đôi.',
  'có được đổi trả không' => 'Bạn có thể đổi trả trong 7 ngày nếu sản phẩm bị lỗi hoặc giao sai. Vui lòng giữ sản phẩm chưa mở.',
  
  // 🤖 Giao tiếp thường gặp
  'hello' => 'Xin chào bạn! Mình là chatbot tư vấn mỹ phẩm. Bạn cần hỗ trợ điều gì hôm nay?',
  'chào bạn' => 'Chào bạn thân mến! Mình có thể giúp gì cho bạn?',
  'bạn là ai' => 'Mình là chatbot tư vấn mỹ phẩm của cửa hàng, mình có thể hỗ trợ bạn chọn sản phẩm hoặc tra cứu thông tin.',
  'cảm ơn' => 'Cảm ơn bạn đã tin tưởng và sử dụng dịch vụ của chúng tôi. Chúc bạn luôn xinh đẹp!',

  // 🌿 Câu hỏi chuyên sâu về sản phẩm
    'da hỗn hợp nên dùng gì' => 'Da hỗn hợp nên dùng các sản phẩm cân bằng như gel dưỡng ẩm, sữa rửa mặt dịu nhẹ, không chứa cồn và có độ pH trung tính.',
    'da nhờn mụn nên dùng gì' => 'Da nhờn và mụn nên dùng sữa rửa mặt có salicylic acid và serum BHA để làm sạch sâu và giảm viêm.',
    'kem dưỡng nào tốt cho mùa đông' => 'Bạn nên chọn kem dưỡng có kết cấu đặc, nhiều dưỡng, chứa ceramide hoặc shea butter để giữ ẩm sâu trong mùa lạnh.',
    'ban ngày nên dùng gì' => 'Ban ngày bạn nên làm sạch mặt, dùng serum dưỡng và chống nắng để bảo vệ da trước môi trường.',
    'ban đêm nên dùng gì' => 'Ban đêm là thời điểm phục hồi da. Bạn nên dùng serum, kem dưỡng có thành phần phục hồi như B5 hoặc Retinol (nếu da khỏe).',
    'có nên dùng nhiều sản phẩm cùng lúc không' => 'Không nên dùng quá nhiều sản phẩm cùng lúc. Hãy bắt đầu từ 2-3 sản phẩm cơ bản, sau đó thêm dần để da thích nghi.',
    'dưỡng da mấy bước là đủ' => 'Cơ bản là 3 bước: làm sạch – dưỡng – chống nắng (ban ngày). Tối ưu là 5 bước nếu da bạn cần chăm sóc chuyên sâu.',
    'retinol là gì' => 'Retinol là dẫn xuất vitamin A, giúp chống lão hoá, trị mụn, làm đều màu da. Cần dùng đúng cách và luôn chống nắng.',
    'niacinamide là gì' => 'Niacinamide (vitamin B3) giúp làm sáng da, giảm thâm, điều tiết dầu và hỗ trợ phục hồi hàng rào da.',
    'squalane là gì' => 'Squalane là thành phần dưỡng ẩm tự nhiên, nhẹ dịu, thẩm thấu nhanh, phù hợp với mọi loại da, kể cả da nhạy cảm.',
    'dùng vitamin C có bị bắt nắng không' => 'Không. Vitamin C không gây bắt nắng, nhưng bạn vẫn cần dùng kem chống nắng vì môi trường bên ngoài luôn có tia UV.',
    'dùng AHA có làm mỏng da không' => 'Nếu dùng đúng nồng độ và tần suất, AHA không làm mỏng da mà còn giúp da mịn và đều màu hơn.',
    'dưỡng trắng có làm hại da không' => 'Nếu bạn dùng các sản phẩm chính hãng, thành phần an toàn thì hoàn toàn không gây hại. Tránh các sản phẩm có chất tẩy trắng.',

    // 💸 Câu hỏi về giá, khuyến mãi, thanh toán
    'có đang giảm giá không' => 'Chúng tôi thường xuyên có khuyến mãi vào cuối tuần hoặc dịp lễ. Bạn có thể xem chi tiết ở banner hoặc mục "Ưu đãi".',
    'giá sản phẩm bao nhiêu' => 'Giá từng sản phẩm sẽ hiển thị ngay dưới hình ảnh. Bạn có thể bấm vào để xem chi tiết và đặt hàng.',
    'có ship COD không' => 'Chúng tôi có hỗ trợ thanh toán khi nhận hàng (COD) toàn quốc.',
    'tôi muốn đổi sản phẩm' => 'Bạn có thể đổi sản phẩm trong vòng 7 ngày nếu sản phẩm chưa mở và còn nguyên tem mác.',
    'có miễn phí ship không' => 'Hiện tại, chúng tôi miễn phí ship với đơn hàng từ 499.000đ trở lên.',
    'thanh toán bằng Momo được không' => 'Hiện tại hệ thống chưa hỗ trợ Momo, nhưng sẽ sớm cập nhật các cổng thanh toán điện tử tiện lợi.',

    //🔐 Câu hỏi về tài khoản, đăng nhập, bảo mật
    'làm sao tạo tài khoản' => 'Bạn vào mục "Đăng ký", nhập email và mật khẩu là tạo được tài khoản mới.',
    'đăng nhập bằng facebook được không' => 'Tạm thời chưa hỗ trợ đăng nhập qua Facebook, bạn vui lòng dùng email và mật khẩu.',
    'có bảo mật thông tin không' => 'Chúng tôi cam kết bảo mật thông tin khách hàng tuyệt đối, không chia sẻ cho bên thứ ba.',
    'đăng xuất thế nào' => 'Bạn chỉ cần nhấn vào nút "Đăng xuất" ở góc trên phải của màn hình.',
    'có cần đăng ký mới mua hàng không' => 'Bạn không cần đăng ký vẫn có thể mua hàng, nhưng nên đăng ký để quản lý đơn hàng và tích điểm dễ dàng hơn.',

    //🛍️ Câu hỏi về tính năng website, điều hướng
    'làm sao quay lại trang chủ' => 'Bạn có thể nhấn vào logo ở góc trái trên cùng để quay về trang chủ.',
    'nút thanh toán ở đâu' => 'Sau khi thêm sản phẩm vào giỏ, bạn vào "Giỏ hàng", rồi nhấn "Thanh toán" ở cuối trang.',
    'làm sao tìm sản phẩm' => 'Bạn có thể nhập tên sản phẩm vào thanh tìm kiếm ở trên đầu trang web.',
    'sắp xếp sản phẩm thế nào' => 'Ở trang sản phẩm, bạn có thể sắp xếp theo giá, đánh giá hoặc mới nhất bằng các tuỳ chọn phía trên.',

    //🤖 Giao tiếp tự nhiên, tương tác thân thiện
    'có ở đó không' => 'Mình luôn ở đây để hỗ trợ bạn. Cần tư vấn gì cứ nhắn cho mình nhé!',
    'bạn làm được gì' => 'Mình có thể giúp bạn chọn sản phẩm phù hợp, tra cứu đơn hàng hoặc giải đáp các câu hỏi về mỹ phẩm.',
    'có rảnh không' => 'Rảnh cực luôn! Nói mình biết bạn đang cần gì nhen!',
    'cho mình hỏi chút' => 'Dạ bạn cứ hỏi thoải mái nhé, mình luôn sẵn sàng hỗ trợ ạ.',
    'cho mình gợi ý' => 'Bạn vui lòng cho biết loại da và nhu cầu của bạn để mình gợi ý phù hợp nhất nhé.',

];

// Trả lời mặc định
$reply = 'Cảm ơn bạn! Tôi sẽ sớm hỗ trợ.';

// Kiểm tra từ khóa và phản hồi
foreach ($answers as $keyword => $ans) {
    if (strpos($question, $keyword) !== false) {
        $reply = $ans;
        break;
    }
}

// Trả về kết quả JSON
echo json_encode(["reply" => $reply]);

