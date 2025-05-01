CREATE TABLE `faculty` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `department` varchar(50) NOT NULL,
  `vote` varchar(10) NOT NULL,
  `reason` text NOT NULL,
  `opinion` text NOT NULL,
  `submitted_at` datetime NOT NULL,
  `total_likes` int(11) DEFAULT 0,
  `role` varchar(10) DEFAULT NULL
) 


CREATE TABLE `student` (
  `id` int(11) NOT NULL,
  `student_id` varchar(10) NOT NULL,
  `role` varchar(10) NOT NULL,
  `vote` varchar(10) NOT NULL,
  `reason` text NOT NULL,
  `opinion` text NOT NULL,
  `submitted_at` datetime NOT NULL,
  `total_likes` int(11) DEFAULT 0
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