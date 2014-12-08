//
//  TabCandidatViewController.m
//  VoteVCMP
//
//  Created by Martin PRILLARD and Vincent COURTADE  on 29/11/13.
//  Copyright (c) 2013 Vot'UTT. All rights reserved.
//

#import "TabViewCandidate.h"
#import "ViewCandidate.h"

@interface TabViewCandidate ()

@property (nonatomic, strong) NSMutableData *responseData;
@end

@implementation TabViewCandidate

@synthesize responseData = _responseData;

- (void)viewDidLoad
{
    [super viewDidLoad];
    //On change le nom du bouton retour
    self.navigationItem.backBarButtonItem =
    [[UIBarButtonItem alloc] initWithTitle:@"Retour aux candidats"
                                     style:UIBarButtonItemStyleBordered
                                    target:nil action:nil];
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
}

-(void)viewWillAppear:(BOOL)animated {
    [super viewWillAppear:animated];
    
    //Parsing JSON
    NSError *error = nil;
    NSData *jsonData = [NSData dataWithContentsOfURL:[NSURL URLWithString:[@"http://www.vote-utt.url.ph/vote_server/vote/get_election.php?election_id=" stringByAppendingString:_electionId]]];
    
    id jsonObjects = [NSJSONSerialization JSONObjectWithData:jsonData options:NSJSONReadingMutableContainers error:&error];
    
    NSArray *candidates = [jsonObjects objectForKey:@"candidates"];
    
    NSMutableArray *listCandidates = [[NSMutableArray alloc] initWithCapacity:[candidates count]];
    
    for (NSDictionary *candidate in candidates)
    {
        //Insertion dans la liste
        [listCandidates insertObject:[NSMutableArray arrayWithObjects:
                                      [candidate objectForKey:@"candidate_id"],
                                      [candidate objectForKey:@"candidate_name"],
                                      [candidate objectForKey:@"candidate_desc"],
                                      [NSString stringWithFormat:@"%@%@", @"http://www.vote-utt.url.ph/candidats/", [candidate objectForKey:@"candidate_url_picture"]],
                                      [candidate objectForKey:@"nbvote"],
                                      [candidate objectForKey:@"percent"],
                                      Nil] atIndex:0];
    }
    
    _maListe = listCandidates;
    
    //On recharge les données, au cas où il y a eu modifications
    [self.tableView reloadData];
    [self.tableView setNeedsDisplay];
}

- (NSInteger)tableView:(UITableView *)tableView numberOfRowsInSection:(NSInteger)section
{
    return [_maListe count];
}

- (UITableViewCell *)tableView:(UITableView *)tableView cellForRowAtIndexPath:(NSIndexPath *)indexPath
{
    static NSString *CandidateIdentifier = @"CandidateIdentifier";
    
    UITableViewCell *cell = [tableView dequeueReusableCellWithIdentifier:CandidateIdentifier];
    
    if (cell == nil)
        cell = [[UITableViewCell alloc] initWithStyle:UITableViewCellStyleDefault reuseIdentifier:CandidateIdentifier];
    
    // Configuration de la cellule
    NSString *candidateName = _maListe[indexPath.row][1];
    NSString *candidateUrlPicture = _maListe[indexPath.row][3];
    NSString *candidateNbVote = _maListe[indexPath.row][4];
    NSString *candidatePercent = _maListe[indexPath.row][5];
    
    //Permet label sur plusieurs lignes si besoin
    cell.textLabel.numberOfLines = 0;
    cell.textLabel.text = candidateName;
    [cell.textLabel sizeToFit];
    //Permet label sur plusieurs lignes si besoin
    cell.detailTextLabel.numberOfLines = 0;
    cell.detailTextLabel.text = [NSString stringWithFormat:@"%@%@%@%@", candidatePercent, @"% (", candidateNbVote, @" voix )"];
    [cell.detailTextLabel sizeToFit];
    
    //Image
    NSURL *url = [NSURL URLWithString:candidateUrlPicture];
    NSData *data = [[NSData alloc] initWithContentsOfURL:url];
    
    UIImageView * imageView = [[UIImageView alloc] initWithFrame:CGRectMake(0, 0, 55, 55)];
    UIImage *tmpImage = [[UIImage alloc] initWithData:data];
    
    imageView.backgroundColor = [UIColor whiteColor];
    imageView.image = tmpImage;
    [cell.contentView addSubview:imageView];


    return cell;
}

-(void)prepareForSegue:(UIStoryboardSegue *)segue sender:(id)sender{
    if([[segue identifier] isEqualToString:@"candidateToCandidateDetail"])
    {
        NSInteger selectedIndex = [[self.tableView indexPathForSelectedRow] row];
        
        //Envoie des donnees a la vue candidat
        ViewCandidate *dvc = [segue destinationViewController];
        dvc.candidateId = [NSString stringWithFormat:@"%@", _maListe[selectedIndex][0]];
        dvc.candidateName = [NSString stringWithFormat:@"%@", _maListe[selectedIndex][1]];
        dvc.candidateDesc = [NSString stringWithFormat:@"%@", _maListe[selectedIndex][2]];
        dvc.candidateUrlPicture = [NSString stringWithFormat:@"%@", _maListe[selectedIndex][3]];
        dvc.candidateNbVote = [NSString stringWithFormat:@"%@", _maListe[selectedIndex][4]];
        dvc.candidatePercent = [NSString stringWithFormat:@"%@", _maListe[selectedIndex][5]];
        dvc.electionId = _electionId;
        dvc.currentElection = _currentElection;
    }
}

@end
