CREATE TABLE `faculty` (
  `id` int(11) PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `department` varchar(50) NOT NULL,
  `vote` varchar(10) NOT NULL,
  `reason` text NOT NULL,
  `role` varchar(10) DEFAULT NULL
) 


CREATE TABLE `student` (
  `student_id` varchar(10) PRIMARY KEY NOT NULL,
  `role` varchar(10) NOT NULL,
  `vote` varchar(10) NOT NULL,
  `reason` text NOT NULL,
) 


-- Indexes for table `faculty`
--
ALTER TABLE `faculty`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for table `faculty`
--
ALTER TABLE `faculty`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;


  CREATE TABLE posts (
    post_id INT PRIMARY KEY AUTO_INCREMENT,
    opinion TEXT NOT NULL,
    total_like INT DEFAULT 0,
    student_id INT DEFAULT NULL,
    faculty_id INT DEFAULT NULL,
    submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    vote VARCHAR(25) NOT NULL,  

    CONSTRAINT fk_student_id FOREIGN KEY (student_id)
        REFERENCES student(student_id)
        ON DELETE SET NULL
        ON UPDATE CASCADE,

    CONSTRAINT fk_faculty_id FOREIGN KEY (faculty_id)
        REFERENCES faculty(id)
        ON DELETE SET NULL
        ON UPDATE CASCADE
);


CREATE TABLE post_likes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  post_id INT NOT NULL,
  user_id INT NOT NULL,
  UNIQUE (post_id, user_id)
);
