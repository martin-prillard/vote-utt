//
//  TabBarVotutt.m
//  VoteVCMP
//
//  Created by Martin PRILLARD and Vincent COURTADE  on 18/12/13.
//  Copyright (c) 2013 Vot'UTT. All rights reserved.
//

#import "TabBarVotutt.h"

@interface TabBarVotutt ()

@end

@implementation TabBarVotutt

- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
    }
    return self;
}

- (void)viewDidLoad
{
    [super viewDidLoad];
    //On change le nom du bouton retour
    self.navigationItem.backBarButtonItem =
    [[UIBarButtonItem alloc] initWithTitle:@"Retour aux élections"
                                     style:UIBarButtonItemStyleBordered
                                    target:nil action:nil];
    self.navigationController.navigationBar.barStyle = UIBarStyleBlackOpaque;
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
}

@end
