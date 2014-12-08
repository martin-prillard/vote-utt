//
//  SecondViewController.m
//  VoteVCMP
//
//  Created by Martin PRILLARD and Vincent COURTADE  on 28/11/13.
//  Copyright (c) 2013 Vot'UTT. All rights reserved.
//

#import "ViewPastElection.h"
#import "TabViewElection.h"

@interface ViewPastElection ()

@property (nonatomic, strong) NSMutableData *responseData;
@end

@implementation ViewPastElection

@synthesize responseData = _responseData;

- (void)viewDidLoad {
    [super viewDidLoad];
    self.navigationController.navigationBar.barStyle = UIBarStyleBlackOpaque;
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
}

- (NSInteger)numberOfSectionsInTableView:(UITableView *)tableView
{
    return 0;
}

- (NSInteger)tableView:(UITableView *)tableView numberOfRowsInSection:(NSInteger)section
{
    return [_maListe count];
}

- (UITableViewCell *)tableView:(UITableView *)tableView cellForRowAtIndexPath:(NSIndexPath *)indexPath
{
    static NSString *CellIdentifier = @"MyIdentifier";
    UITableViewCell *cell = [tableView dequeueReusableCellWithIdentifier:CellIdentifier forIndexPath:indexPath];
    
    return cell;
}

-(void)prepareForSegue:(UIStoryboardSegue *)segue sender:(id)sender{
    if([[segue identifier] isEqualToString:@"PastElectionToElection"])
    {
        
        //Parsing JSON
        NSError *error = nil;
        NSData *jsonData = [NSData dataWithContentsOfURL:[NSURL URLWithString:@"http://www.vote-utt.url.ph/vote_server/vote/get_all_past_election.php"]];
        
        id jsonObjects = [NSJSONSerialization JSONObjectWithData:jsonData options:NSJSONReadingMutableContainers error:&error];
        
        NSArray *elections = [jsonObjects objectForKey:@"elections"];
        
        NSMutableArray *listElection = [[NSMutableArray alloc] initWithCapacity:[elections count]];
        
        for (NSDictionary *election in elections)
        {
            
            //Insertion dans la liste
            [listElection insertObject:[NSMutableArray arrayWithObjects:
                                        [election objectForKey:@"election_id"],
                                        [election objectForKey:@"election_label"],
                                        [election objectForKey:@"election_time_start"],
                                        [election objectForKey:@"election_time_end"],
                                        [election objectForKey:@"election_total_vote"],
                                        nil] atIndex:0];
        }
        
        TabViewElection *tve = [segue destinationViewController];
        tve.maListe = listElection;
        tve.currentElection = NO;
    }
}


@end
