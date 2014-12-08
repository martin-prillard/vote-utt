ALTER TABLE `attempt_signin` 
  ADD CONSTRAINT `attempt_signin_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

ALTER TABLE `election_candidate`
  ADD CONSTRAINT `election_candidate_ibfk_2` FOREIGN KEY (`candidate_id`) REFERENCES `candidate` (`candidate_id`),
  ADD CONSTRAINT `election_candidate_ibfk_1` FOREIGN KEY (`election_id`) REFERENCES `election` (`election_id`);
  
ALTER TABLE `vote`
  ADD CONSTRAINT `vote_ibfk_3` FOREIGN KEY (`election_id`) REFERENCES `election` (`election_id`),
  ADD CONSTRAINT `vote_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`),
  ADD CONSTRAINT `vote_ibfk_2` FOREIGN KEY (`candidate_id`) REFERENCES `candidate` (`candidate_id`);