//
//  TabVoteViewController.h
//  VoteVCMP
//
//  Created by Martin PRILLARD and Vincent COURTADE  on 28/11/13.
//  Copyright (c) 2013 Vot'UTT. All rights reserved.
//

#import <UIKit/UIKit.h>

@interface TabViewElection : UITableViewController

@property (strong, nonatomic) NSMutableArray *maListe;
@property BOOL *currentElection;
@property (strong, nonatomic) IBOutlet UITableView *tableView;

@end
