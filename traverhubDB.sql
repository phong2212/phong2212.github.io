-- Tạo cơ sở dữ liệu mới
CREATE DATABASE travelhubDB;

-- Bảng Châu lục
CREATE TABLE Continents (
    ContinentID INT PRIMARY KEY AUTO_INCREMENT,
    Name VARCHAR(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=UTF8MB4_GENERAL_CI;

-- Bảng để lưu trữ thông tin về các điểm đến du lịch
CREATE TABLE Destinations (
    DestinationID INT PRIMARY KEY AUTO_INCREMENT,
    Name VARCHAR(50) NOT NULL,
    Description TEXT,
    Location VARCHAR(50),
    ContinentID INT,
    FOREIGN KEY (ContinentID) REFERENCES Continents (ContinentID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=UTF8MB4_GENERAL_CI;

-- Bảng để lưu trữ thông tin về người dùng
CREATE TABLE users (
    UserID INT PRIMARY KEY AUTO_INCREMENT,
    Username VARCHAR(50) NOT NULL,
    Password VARCHAR(100) NOT NULL,
    IsAdmin TINYINT(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=UTF8MB4_GENERAL_CI;

-- Bảng để lưu trữ thông tin cá nhân của người dùng
CREATE TABLE UserProfiles (
    UserID INT PRIMARY KEY,
    Email VARCHAR(50) NOT NULL,
    Fullname VARCHAR(50) DEFAULT NULL,
    Address VARCHAR(255) DEFAULT NULL,
    Phone VARCHAR(10) DEFAULT NULL,
    FOREIGN KEY (UserID) REFERENCES Users (UserID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=UTF8MB4_GENERAL_CI;

-- Bảng để lưu trữ các blog về du lịch
CREATE TABLE Blogs (
    BlogID INT PRIMARY KEY AUTO_INCREMENT,
    UserID INT,
    Title VARCHAR(100) NOT NULL,
    Content TEXT,
    CreatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (UserID) REFERENCES Users (UserID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=UTF8MB4_GENERAL_CI;

-- Bảng để liên kết người dùng với các điểm đến du lịch yêu thích
CREATE TABLE Favorites (
    UserID INT,
    DestinationID INT,
    FOREIGN KEY (UserID) REFERENCES Users (UserID),
    FOREIGN KEY (DestinationID) REFERENCES Destinations (DestinationID),
    PRIMARY KEY (UserID, DestinationID)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=UTF8MB4_GENERAL_CI;

-- Dữ liệu nhập
INSERT INTO Continents (Name) VALUES 
    ('Châu Á'),
    ('Châu Âu'),
    ('Châu Mỹ'),
    ('Châu Phi'),
    ('Châu Úc');
    
    
INSERT INTO Destinations (Name, Description, Location, ContinentID) VALUES 
    ('Núi Phú Sĩ', 'Ngọn núi linh thiêng trong văn hóa Nhật Bản', 'Tokyo, Nhật Bản', 1),
    ('Vịnh Hạ Long', 'Di sản thiên nhiên thế giới ở Việt Nam', 'Quảng Ninh, Việt Nam', 1),
    ('Thành phố Paris', 'Thủ đô lãng mạn của Pháp', 'Paris, Pháp', 2),
    ('Đảo Santorini', 'Hòn đảo nổi tiếng với kiến trúc trắng xinh đẹp', 'Nam Aegean, Hy Lạp', 2),
    ('Grand Canyon', 'Kỳ quan thiên nhiên tại Hoa Kỳ', 'Arizona, Hoa Kỳ', 3),
    ('Công viên quốc gia Yellowstone', 'Vùng đất hoang sơ với nhiều loài động vật', 'Wyoming, Hoa Kỳ', 3),
    ('Đồng bằng châu Phi', 'Khu vực đa dạng văn hóa và thiên nhiên ấn tượng', 'Châu Phi', 4),
    ('Thác Victoria', 'Một trong những thác nước lớn nhất thế giới', 'Livingstone, Zambia', 4),
    ('Vịnh Hạnh phúc', 'Địa điểm nghỉ dưỡng tại Úc nổi tiếng', 'Queensland, Úc', 5),
    ('Rừng già Daintree', 'Khu rừng già nhiệt đới lâu dài nhất thế giới', 'Queensland, Úc', 5),
    ('Thành phố Tokyo', 'Trung tâm của công nghiệp và văn hóa Nhật Bản', 'Tokyo, Nhật Bản', 1),
    ('Thành phố Rome', 'Trung tâm lịch sử và văn hóa của Ý', 'Rome, Ý', 2),
    ('Khu du lịch Serengeti', 'Thảo nguyên lớn tại Tanzania với động vật hoang dã', 'Tanzania', 4),
    ('Đảo New Zealand', 'Quốc đảo nằm ở tận cùng phía nam của Thái Bình Dương', 'New Zealand', 5),
    ('Đảo Maldives', 'Đảo quốc nổi tiếng với bãi biển đẹp và resort sang trọng', 'Maldives', 5),
    ('Thành phố New York', 'Thủ đô tài chính và văn hóa của Hoa Kỳ', 'New York, Hoa Kỳ', 3),
    ('Khu du lịch Machu Picchu', 'Di sản thế giới của người Inca tại Peru', 'Cusco, Peru', 2),
    ('Vịnh Alaska', 'Khu vực độc đáo với cảnh đẹp thiên nhiên hùng vĩ', 'Alaska, Hoa Kỳ', 3),
    ('Quần đảo Fiji', 'Quốc đảo nổi tiếng với bãi biển và rạn san hô đẹp', 'Fiji', 5);

INSERT INTO UserProfiles (UserID, Email, Fullname, Address, Phone) VALUES
(2, 'user1@example.com', 'User One', '123 Can Tho', '0999999999'),
(3, 'user2@example.com', 'User Two', '234 Can Tho', '0999999998')

INSERT INTO Blogs (UserID, Title, Content) VALUES
(1, 'Blog Đầu Tiên của Quản Trị Viên', 'This is the content of the first blog written by the admin.'),
(2, 'Giới Thiệu Về Du Lịch', 'In this blog, we will discuss the basics of SQL.'),
(3, 'Những Suy nghĩ của Phong', 'User2 shares some thoughts and experiences in this blog post.');


INSERT INTO Favorites (UserID, DestinationID)
VALUES
(1, 1), (1, 2), (1, 3), (1, 4), (2, 5),
(1, 19), (2, 7), (2, 8), (2, 9), (2, 10),
(3, 11), (1, 12), (3, 13), (3, 14), (3, 15),
(4, 16), (4, 17), (4, 18), (4, 19), (4, 20),
(1, 5), (3, 5), (4, 5), (1, 27), (2, 27),
(1, 6), (3, 6), (2, 6), (2, 16),
(3, 7), (3, 8), (1, 7), (4, 8),
(1, 11), (4, 11), (3, 12),
(4, 26), (4, 21);