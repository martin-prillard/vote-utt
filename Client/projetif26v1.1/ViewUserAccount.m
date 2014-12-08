//
//  ViewUserAccount.m
//  VoteVCMP
//
//  Created by Martin PRILLARD and Vincent COURTADE  on 06/12/13.
//  Copyright (c) 2013 Vot'UTT. All rights reserved.
//

#import "ViewUserAccount.h"
#import "ViewCurrentElection.h"
#import "AppDelegate.h"
#import "UIViewController+Authentication.h"

@interface ViewUserAccount ()

@end

@implementation ViewUserAccount

- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    return self;
}

- (void)viewDidLoad
{
    [super viewDidLoad];
    _j_emailSignin.delegate = self;
    _j_passwordSignin.delegate = self;
    _j_emailSignup.delegate = self;
    _j_passwordSignup.delegate = self;
    _j_passwordBisSignup.delegate = self;
    self.activeField = [[UITextField alloc]init];
    [self registerForKeyboardNotifications];
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
}


-(void)viewWillAppear:(BOOL)animated {
    [super viewWillAppear:animated];
    
    //On verifie que l'utilisateur est connecte
    NSString *url = [NSString stringWithFormat:@"%@%@%@%@",
                     @"http://www.vote-utt.url.ph/vote_server/account/isConnect.php?user_id=",
                     self.userId,
                     @"&user_token=",
                     self.userToken];
    url = [url stringByAddingPercentEscapesUsingEncoding:NSASCIIStringEncoding];
    
    //Parsing JSON
    NSError *error = nil;
    NSData *jsonData = [NSData dataWithContentsOfURL:[NSURL URLWithString:url]];
    
    id jsonObjects = [NSJSONSerialization JSONObjectWithData:jsonData options:NSJSONReadingMutableContainers error:&error];
    
    BOOL *isConnect = [[jsonObjects objectForKey:@"is_connect"] boolValue];

    if(isConnect) {
        //On affiche le bouton Deconnexion et on grise et masque les autres
        self.j_emailSignin.enabled = false;
        self.j_passwordSignin.enabled = false;
        self.b_signin.enabled = false;
        self.j_emailSignup.enabled = false;
        self.j_passwordSignup.enabled = false;
        self.j_passwordBisSignup.enabled = false;
        self.b_signup.enabled = false;
        //Cacher
        self.l_signin.hidden = true;
        self.j_emailSignin.hidden = true;
        self.j_passwordSignin.hidden = true;
        self.b_signin.hidden = true;
        self.l_signup.hidden = true;
        self.j_emailSignup.hidden = true;
        self.j_passwordSignup.hidden = true;
        self.j_passwordBisSignup.hidden = true;
        self.b_signup.hidden = true;
        //Afficher
        self.b_signout.hidden = false;
    } else {
        //On affiche les composants pour se connecter et s'inscrire et on masque celui pour se deconnecter
        self.j_emailSignin.enabled = true;
        self.j_passwordSignin.enabled = true;
        self.b_signin.enabled = true;
        self.j_emailSignup.enabled = true;
        self.j_passwordSignup.enabled = true;
        self.j_passwordBisSignup.enabled = true;
        self.b_signup.enabled = true;
        //cacher
        self.b_signout.hidden = true;
        //Afficher
        self.l_signin.hidden = false;
        self.j_emailSignin.hidden = false;
        self.j_passwordSignin.hidden = false;
        self.b_signin.hidden = false;
        self.l_signup.hidden = false;
        self.j_emailSignup.hidden = false;
        self.j_passwordSignup.hidden = false;
        self.j_passwordBisSignup.hidden = false;
        self.b_signup.hidden = false;
    }
    
}

//Action de se connecter
- (IBAction)b_signin:(id)sender {
    
    NSString *email = _j_emailSignin.text;
    NSString *password = _j_passwordSignin.text;

    //On efface le mot de passe entre par l'utilisateur
    _j_passwordSignin.text = @"";
    
    if ([_j_emailSignin.text length] == 0) {
        email = @"";
    }
    
    NSString *url = [NSString stringWithFormat:@"%@%@%@%@",
                           @"http://www.vote-utt.url.ph/vote_server/account/signin.php?user_email=",
                           email,
                           @"&user_password=",
                           password];
    url = [url stringByAddingPercentEscapesUsingEncoding:NSUTF8StringEncoding];
  
    //Parsing JSON
    NSError *error = nil;
    NSData *jsonData = [NSData dataWithContentsOfURL:[NSURL URLWithString:url]];
    
    id jsonObjects = [NSJSONSerialization JSONObjectWithData:jsonData options:NSJSONReadingMutableContainers error:&error];
    

    NSInteger *errorCodeInt = [[jsonObjects objectForKey:@"error_code"] integerValue];
    int errorCode = errorCodeInt;
    
    //Si succès
    if (errorCode == 0) {
        self.signinSucces = YES;
        NSString *title = @"Connexion réussie";
        NSString *content = @"Vous nous avez manqué !";
        [self showSimpleAlert:title withContent:content];
    //Si erreurs
    } else if (errorCode == 1 || errorCode == 2 || errorCode == 3 || errorCode == 4) {
        self.signinSucces = NO;
        NSString *title = @"Erreur lors de la connexion";
        NSString *content = @"Veuillez entrer un email et un mot de passe valide.";
        [self showSimpleAlert:title withContent:content];
    //Si erreur compte non valide
    } else if (errorCode == 5) {
        self.signinSucces = NO;
        NSString *title = @"Veuillez valider votre compte";
        NSString *content = @"Voulez-vous que l'on vous renvoie l'email de validation du compte ?";
        UIAlertView *alert = [[UIAlertView alloc]
                              initWithTitle:title
                              message:content
                              delegate:self
                              cancelButtonTitle:@"Cancel"
                              otherButtonTitles:@"OK", nil];
        [alert show];
    }
    
    id user_id = [jsonObjects objectForKey:@"user_id"];
    id token = [jsonObjects objectForKey:@"token"];

    //On recupere l'id de l'utilisateur connecte et son token
    AppDelegate* appDelegate = (AppDelegate*)[[UIApplication sharedApplication] delegate];
    
    if(( user_id && ![user_id isKindOfClass:[NSNull class]] )
        && (token && ![token isKindOfClass:[NSNull class]]))
    {
        appDelegate.userId = [NSString stringWithFormat:@"%@", [jsonObjects objectForKey:@"user_id"]];
        appDelegate.userToken = [NSString stringWithFormat:@"%@", [jsonObjects objectForKey:@"token"]];
    }
    else
    {
        appDelegate.userId = @"";
        appDelegate.userToken = @"";
    }

}

//Action de l'alert view
- (void)alertView:(UIAlertView *)alertView
clickedButtonAtIndex:(NSInteger) buttonIndex{
    
    //OK
    if (buttonIndex == 1) {
        
        NSString *email = _j_emailSignin.text;
        
        //On renvoit le mail de validation du compte
        NSString *url = [NSString stringWithFormat:@"%@%@",
                         @"http://www.vote-utt.url.ph/vote_server/account/sendValidationEmail.php?user_email=",
                         email];
        url = [url stringByAddingPercentEscapesUsingEncoding:NSASCIIStringEncoding];
        
        //Parsing JSON
        NSError *error = nil;
        NSData *jsonData = [NSData dataWithContentsOfURL:[NSURL URLWithString:url]];
        
        [NSJSONSerialization JSONObjectWithData:jsonData options:NSJSONReadingMutableContainers error:&error];
        
        //Affichage de confirmation du message envoye
        NSString *title = @"Mail de confirmation envoyé";
        NSString *content = @"Pour valider votre compte, cliquez sur le lien du mail.";
        [self showSimpleAlert:title withContent:content];
    }
}

//Methode appele avant de passe a une autre vue
- (BOOL)shouldPerformSegueWithIdentifier:(NSString *)identifier sender:(id)sender
{
    if (sender == self.b_signin)
    {
        //Si tentative de connexion succes
        if (self.signinSucces) {
            return YES;
        }else{
            return NO;
        }
    } else {
        return YES;
    }
}

//Action de l'inscription
- (IBAction)b_signup:(id)sender {
    NSString *email = _j_emailSignup.text;
    NSString *password = _j_passwordSignup.text;
    NSString *passwordBis = _j_passwordBisSignup.text;
    
    if ([_j_emailSignup.text length] == 0) {
        email = @"";
    }
    if ([_j_passwordSignup.text length] == 0) {
        password = @"";
    }
    if ([_j_passwordBisSignup.text length] == 0) {
        passwordBis = @"";
    }
    
    //On efface le mot de passe entre par l'utilisateur
    _j_passwordSignup.text = @"";
    _j_passwordBisSignup.text = @"";
    
    NSString *url = [NSString stringWithFormat:@"%@%@%@%@%@%@",
                     @"http://www.vote-utt.url.ph/vote_server/account/signup.php?user_email=",
                     email,
                     @"&user_password=",
                     password,
                     @"&user_password_bis=",
                     passwordBis];
    url = [url stringByAddingPercentEscapesUsingEncoding:NSUTF8StringEncoding];
    
    //Parsing JSON
    NSError *error = nil;
    NSData *jsonData = [NSData dataWithContentsOfURL:[NSURL URLWithString:url]];

    id jsonObjects = [NSJSONSerialization JSONObjectWithData:jsonData options:NSJSONReadingMutableContainers error:&error];
    
    BOOL *errorCode = [[jsonObjects objectForKey:@"error"] boolValue];
    
    
    //Si erreur lors de l'inscription
    if(errorCode) {
        NSString *title = @"Erreur lors de l'inscription";
        NSString *content = [jsonObjects objectForKey:@"error_msg"];
        [self showSimpleAlert:title withContent:content];
    } else {
        NSString *title = @"Mail de confirmation envoyé";
        NSString *content = @"Pour valider votre compte, cliquez sur le lien du mail.";
        [self showSimpleAlert:title withContent:content];
        //On efface le mail de l'utilisateur et on le place dans la partie connexion
        _j_emailSignin.text = _j_emailSignup.text;
        _j_emailSignup.text = @"";
    }
    
}

//Methode pour gerer l'affichage du clavier
- (BOOL)textFieldShouldReturn:(UITextField *)textField {
    [_j_emailSignin resignFirstResponder];
    [_j_passwordSignin resignFirstResponder];
    [_j_emailSignup resignFirstResponder];
    [_j_passwordSignup resignFirstResponder];
    [_j_passwordBisSignup resignFirstResponder];
    
    return YES    ;
}

//Action de la deconnexion
- (IBAction)signout:(id)sender {
    
    //On supprime le token en base
    NSString *url = [NSString stringWithFormat:@"%@%@%@%@",
                     @"http://www.vote-utt.url.ph/vote_server/account/signout.php?user_id=",
                     self.userId,
                     @"&user_token=",
                     self.userToken];
    url = [url stringByAddingPercentEscapesUsingEncoding:NSASCIIStringEncoding];
    
    //Parsing JSON
    NSError *error = nil;
    NSData *jsonData = [NSData dataWithContentsOfURL:[NSURL URLWithString:url]];
    
    [NSJSONSerialization JSONObjectWithData:jsonData options:NSJSONReadingMutableContainers error:&error];
    
    
    //On recupere l'id de l'utilisateur connecte et son token et on les reinitialisent à null
    AppDelegate* appDelegate = (AppDelegate*)[[UIApplication sharedApplication] delegate];

    appDelegate.userId = @"";
    appDelegate.userToken = @"";
}

//Affiche une alert simple
- (void)showSimpleAlert:(NSString *)title withContent:(NSString *)content {
    UIAlertView *alert = [[UIAlertView alloc] initWithTitle:title message:content delegate: nil cancelButtonTitle:@"OK" otherButtonTitles:nil];
    [alert show];
}

// Call this method somewhere in your view controller setup code.
- (void)registerForKeyboardNotifications
{
    [[NSNotificationCenter defaultCenter] addObserver:self
                                             selector:@selector(keyboardWasShown:)
                                                 name:UIKeyboardDidShowNotification object:nil];
    
    [[NSNotificationCenter defaultCenter] addObserver:self
                                             selector:@selector(keyboardWillBeHidden:)
                                                 name:UIKeyboardWillHideNotification object:nil];
    
}

- (void)keyboardWasShown:(NSNotification*)aNotification {
    NSDictionary* info = [aNotification userInfo];
    CGSize kbSize = [[info objectForKey:UIKeyboardFrameBeginUserInfoKey] CGRectValue].size;
    CGRect bkgndRect = self.activeField.superview.frame;
    bkgndRect.size.height += kbSize.height;
    [self.activeField.superview setFrame:bkgndRect];
    [self.scrollView setContentOffset:CGPointMake(0.0, self.activeField.frame.origin.y-kbSize.height/2) animated:YES];
}

// Called when the UIKeyboardWillHideNotification is sent
- (void)keyboardWillBeHidden:(NSNotification*)aNotification
{
    UIEdgeInsets contentInsets = UIEdgeInsetsZero;
    [self.scrollView setContentOffset:CGPointMake(0.0, 0.0) animated:YES];
    self.scrollView.scrollIndicatorInsets = contentInsets;
}

- (void)textFieldDidBeginEditing:(UITextField *)textField
{
    self.activeField = textField;
}

- (void)textFieldDidEndEditing:(UITextField *)textField
{
    self.activeField = nil;
}

@end
