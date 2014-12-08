//
//  DetailViewController.m
//  VoteVCMP
//
//  Created by Martin PRILLARD and Vincent COURTADE  on 28/11/13.
//  Copyright (c) 2013 Vot'UTT. All rights reserved.
//

#import "ViewCandidate.h"
#import "AppDelegate.h"
#import "UIViewController+Authentication.h"

@interface ViewCandidate ()

@end

@implementation ViewCandidate


- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
    }
    return self;
}

-(void)viewWillAppear:(BOOL)animated {
    [super viewWillAppear:animated];
    
    //L'utilisateur peut voter
    if (_currentElection) {
        self.b_vote.enabled = true;
        self.b_vote.hidden = false;

    //On masque et desactive le bouton voter
    } else {
        self.b_vote.enabled = false;
        self.b_vote.hidden = true;
    }

    //On actualise l'affichage
    
    //Permet label sur plusieurs lignes si besoin
    self.l_percent.numberOfLines = 0;
    self.l_percent.text = [NSString stringWithFormat:@"%@%@%@%@", _candidatePercent, @"% (", _candidateNbVote, @" voix )"];
    [self.l_percent sizeToFit];
    //Permet label sur plusieurs lignes si besoin
    self.l_candidateName.numberOfLines = 0;
    self.l_candidateName.text = _candidateName;
    [self.l_candidateName sizeToFit];

    self.t_candidateDesc.text = _candidateDesc;
    
    //Image
    NSURL *url = [NSURL URLWithString:_candidateUrlPicture];
    NSData *data = [[NSData alloc] initWithContentsOfURL:url];
    UIImage *tmpImage = [[UIImage alloc] initWithData:data];
    self.i_candidatePicture.contentMode = UIViewContentModeScaleAspectFit;
    self.i_candidatePicture.backgroundColor = [UIColor whiteColor];
    self.i_candidatePicture.image = tmpImage;
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
}

- (void)viewDidUnload {
    [super viewDidUnload];
}

- (IBAction)b_vote:(id)sender {
    
    //On test le vote
    NSString *url = [NSString stringWithFormat:@"%@%@%@%@%@%@%@%@",
                     @"http://www.vote-utt.url.ph/vote_server/vote/vote.php?user_id=",
                     self.userId,
                     @"&user_token=",
                     self.userToken,
                     @"&election_id=",
                     _electionId,
                     @"&candidate_id=",
                     _candidateId];
    url = [url stringByAddingPercentEscapesUsingEncoding:NSASCIIStringEncoding];
    
    //Parsing JSON
    NSError *error = nil;
    NSData *jsonData = [NSData dataWithContentsOfURL:[NSURL URLWithString:url]];
    
    id jsonObjects = [NSJSONSerialization JSONObjectWithData:jsonData options:NSJSONReadingMutableContainers error:&error];
    BOOL *errorCode = [[jsonObjects objectForKey:@"error"] boolValue];

    //Affiche un message de succes ou d'erreur de la tentative de vote
    if(errorCode) {
        NSString *errorMsg = [jsonObjects objectForKey:@"error_msg"];
        UIAlertView *alert = [[UIAlertView alloc] initWithTitle:@"Erreur lors du vote" message:errorMsg delegate: nil cancelButtonTitle:@"OK" otherButtonTitles:nil];
        [alert show];
    } else {
        NSString *msg = @"A voter !";
        UIAlertView *alert = [[UIAlertView alloc] initWithTitle:@"Succès du vote" message:msg delegate: nil cancelButtonTitle:@"OK" otherButtonTitles:nil];
        [alert show];
    }

}

-(void)tabBarController:(UITabBarController *)tabBarController didSelectViewController:(UIViewController *)viewController {}

@end
