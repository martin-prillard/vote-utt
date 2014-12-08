-- insertion du candidat vote blanc

INSERT INTO `candidate`(`candidate_name`, `candidate_desc`, `candidate_url_picture`) VALUES ("Vote blanc", "Lors d'une �lection, le vote blanc est le fait de ne voter pour aucun des candidats, ou aucune des propositions dans le cas d'un r�f�rendum. � Le vote blanc consiste pour un �lecteur � d�poser dans l�urne un bulletin d�pourvu de tout nom de candidat (ou de toute indication dans le cas d�un r�f�rendum) �", "https://pbs.twimg.com/profile_images/1540279908/test5.jpg")


-- trigger qui ajoute le candidat vote blanc lorsqu'une election est creee

DELIMITER $$

CREATE TRIGGER ins_white_vote
AFTER INSERT ON election
FOR EACH ROW BEGIN
	DECLARE white_vote_id integer(10); 
	select candidate.candidate_id into @white_vote_id 
	from candidate where candidate_name = "Vote blanc"; 
    INSERT INTO election_candidate VALUES (new.election_id, @white_vote_id);
END$$

DELIMITER ;

