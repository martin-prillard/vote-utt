//
//  FirstViewController.m
//  VoteVCMP
//
//  Created by Martin PRILLARD and Vincent COURTADE  on 28/11/13.
//  Copyright (c) 2013 Vot'UTT. All rights reserved.
//

#import "ViewCurrentElection.h"
#import "UIViewController+Authentication.h"
#import "TabViewElection.h"

@interface ViewCurrentElection ()

@end

@implementation ViewCurrentElection

- (void)viewDidLoad {
    [super viewDidLoad];
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
}

- (NSInteger)numberOfSectionsInTableView:(UITableView *)tableView
{
    return 0;
}

- (void)viewDidUnload {
    [super viewDidUnload];
}

- (NSInteger)tableView:(UITableView *)tableView numberOfRowsInSection:(NSInteger)section
{
    return [self.listElection count];
}

- (UITableViewCell *)tableView:(UITableView *)tableView cellForRowAtIndexPath:(NSIndexPath *)indexPath
{
   static NSString *CellIdentifier = @"MyIdentifier";
   UITableViewCell *cell = [tableView dequeueReusableCellWithIdentifier:CellIdentifier forIndexPath:indexPath];
    
   return cell;
}

-(void)prepareJSON {
    //Parsing JSON
    NSError *error = nil;
    NSData *jsonData = [NSData dataWithContentsOfURL:[NSURL URLWithString:@"http://www.vote-utt.url.ph/vote_server/vote/get_all_current_election.php"]];
    
    id jsonObjects = [NSJSONSerialization JSONObjectWithData:jsonData options:NSJSONReadingMutableContainers error:&error];
    
    NSArray *elections = [jsonObjects objectForKey:@"elections"];
    
    self.listElection = [[NSMutableArray alloc] initWithCapacity:[elections count]];
    
    for (NSDictionary *election in elections)
    {
        
        //Insertion dans la liste
        [self.listElection insertObject:[NSMutableArray arrayWithObjects:
                                         [election objectForKey:@"election_id"],
                                         [election objectForKey:@"election_label"],
                                         [election objectForKey:@"election_time_start"],
                                         [election objectForKey:@"election_time_end"],
                                         [election objectForKey:@"election_total_vote"],
                                         nil] atIndex:0];
    }
}

-(void)prepareForSegue:(UIStoryboardSegue *)segue sender:(id)sender{

    if([[segue identifier] isEqualToString:@"CurrentElectionToElection"])
    {
        [self prepareJSON];
        TabViewElection *tve = [segue destinationViewController];
        tve.maListe = self.listElection;
        tve.currentElection = YES;
    }
}


@end
