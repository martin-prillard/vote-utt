//
//  TabVoteViewController.m
//  VoteVCMP
//
//  Created by Martin PRILLARD and Vincent COURTADE  on 28/11/13.
//  Copyright (c) 2013 Vot'UTT. All rights reserved.
//

#import "TabViewElection.h"
#import "ViewCandidate.h"
#import "TabViewCandidate.h"

@interface TabViewElection ()

@end

@implementation TabViewElection

- (void)viewDidLoad
{
    [super viewDidLoad];
}

-(void)prepareForSegue:(UIStoryboardSegue *)segue sender:(id)sender{
    if([[segue identifier] isEqualToString:@"electionToCandidate"])
    {
        
        NSInteger selectedIndex = [[self.tableView indexPathForSelectedRow] row];
        
        TabViewCandidate *tcvc = [segue destinationViewController];
        tcvc.electionId = [NSString stringWithFormat:@"%@", _maListe[selectedIndex][0]];
        tcvc.currentElection = _currentElection;
    }
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
}

- (NSInteger)tableView:(UITableView *)tableView numberOfRowsInSection:(NSInteger)section
{
    return [_maListe count];
}

-(void)viewWillAppear:(BOOL)animated {
    [super viewWillAppear:animated];
    
    //On recharge les données, au cas où il y a eu modifications
    [self.tableView reloadData];
    [self.tableView setNeedsDisplay];
}

//Methode appele avant de passe a une autre vue
- (BOOL)shouldPerformSegueWithIdentifier:(NSString *)identifier sender:(id)sender
{
    return YES;
}

- (UITableViewCell *)tableView:(UITableView *)tableView cellForRowAtIndexPath:(NSIndexPath *)indexPath
{
    static NSString *ElectionIdentifier = @"ElectionIdentifier";
    
    UITableViewCell *cell = [tableView dequeueReusableCellWithIdentifier:ElectionIdentifier];
    
    if (cell == nil)
        cell = [[UITableViewCell alloc] initWithStyle:UITableViewCellStyleDefault reuseIdentifier:ElectionIdentifier];
    
    NSString *electionLabel = _maListe[indexPath.row][1];
    NSString *electionTimeStart = _maListe[indexPath.row][2];
    NSString *electionTimeEnd = _maListe[indexPath.row][3];
    int totalVote = [_maListe[indexPath.row][4] intValue];

    //Permet label sur plusieurs lignes si besoin
    cell.textLabel.numberOfLines = 0;
    //Ajoute un "s" à vote si besoin
    if (totalVote <= 1) {
        cell.textLabel.text = [NSString stringWithFormat:@"%@%@%@%@", electionLabel, @" (", [NSString stringWithFormat: @"%d", totalVote], @" vote)"];
    } else {
        cell.textLabel.text = [NSString stringWithFormat:@"%@%@%@%@", electionLabel, @" (", [NSString stringWithFormat: @"%d", totalVote], @" votes)"];
    }
    [cell.textLabel sizeToFit];
    
    cell.detailTextLabel.text = [NSString stringWithFormat:@"%@%@%@", electionTimeStart, @" - ", electionTimeEnd];
    
    return cell;
}



@end
