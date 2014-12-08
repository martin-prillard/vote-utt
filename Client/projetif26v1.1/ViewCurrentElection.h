//
//  FirstViewController.h
//  VoteVCMP
//
//  Created by Martin PRILLARD and Vincent COURTADE  on 28/11/13.
//  Copyright (c) 2013 Vot'UTT. All rights reserved.
//


#import <UIKit/UIKit.h>

@interface ViewCurrentElection : UIViewController <UITableViewDelegate, UITableViewDataSource>

@property (nonatomic, retain) NSMutableArray *listElection;
@property (weak, nonatomic) IBOutlet UILabel *titre_en_cours;
@property (weak, nonatomic) IBOutlet UINavigationItem *bartop;
@property (strong, nonatomic) IBOutlet UIView *viewCurrentElection;

@end
