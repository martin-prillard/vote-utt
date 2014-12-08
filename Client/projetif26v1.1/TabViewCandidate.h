//
//  TabCandidatViewController.h
//  VoteVCMP
//
//  Created by Martin PRILLARD and Vincent COURTADE  on 29/11/13.
//  Copyright (c) 2013 Vot'UTT. All rights reserved.
//

#import <UIKit/UIKit.h>

@interface TabViewCandidate : UITableViewController

@property (nonatomic, retain) NSMutableArray *maListe;
@property (strong, nonatomic) id electionId;
@property (strong, nonatomic) id candidateName;
@property BOOL *currentElection;

@end
