//
//  DetailViewController.h
//  VoteVCMP
//
//  Created by Martin PRILLARD and Vincent COURTADE  on 28/11/13.
//  Copyright (c) 2013 Vot'UTT. All rights reserved.
//

#import <UIKit/UIKit.h>

@interface ViewCandidate : UIViewController

@property (weak, nonatomic) IBOutlet UIImageView *i_candidatePicture;
@property (weak, nonatomic) IBOutlet UITextView *t_candidateDesc;
@property (weak, nonatomic) IBOutlet UILabel *l_candidateName;
@property (weak, nonatomic) IBOutlet UILabel *l_percent;
@property (weak, nonatomic) IBOutlet UIButton *b_vote;
- (IBAction)b_vote:(id)sender;
@property (strong, nonatomic) id electionId;
@property (strong, nonatomic) id candidateId;
@property (strong, nonatomic) id candidateName;
@property (strong, nonatomic) id candidateDesc;
@property (strong, nonatomic) id candidateNbVote;
@property (strong, nonatomic) id candidatePercent;
@property (strong, nonatomic) id candidateUrlPicture;
@property BOOL *currentElection;
@property (strong, nonatomic) IBOutlet UIView *viewCandidate;

@end

