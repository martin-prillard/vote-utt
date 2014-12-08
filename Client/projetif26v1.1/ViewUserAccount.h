//
//  ViewUserAccount.h
//  VoteVCMP
//
//  Created by Martin PRILLARD and Vincent COURTADE  on 06/12/13.
//  Copyright (c) 2013 Vot'UTT. All rights reserved.
//

#import <UIKit/UIKit.h>

@interface ViewUserAccount : UIViewController <UITextFieldDelegate>
@property (weak, nonatomic) IBOutlet UITextField *j_passwordSignin;
@property (weak, nonatomic) IBOutlet UITextField *j_emailSignup;
@property (weak, nonatomic) IBOutlet UITextField *j_passwordSignup;
@property (weak, nonatomic) IBOutlet UITextField *j_passwordBisSignup;

@property (weak, nonatomic) IBOutlet UITextField *j_emailSignin;
@property (weak, nonatomic) IBOutlet UILabel *l_signup;
@property (weak, nonatomic) IBOutlet UIScrollView *scrollView;
@property (weak, nonatomic) IBOutlet UILabel *l_signin;
@property (weak, nonatomic) IBOutlet UIButton *b_signin;
@property (weak, nonatomic) IBOutlet UIButton *b_signup;
@property (weak, nonatomic) IBOutlet UIButton *b_signout;
@property IBOutlet UITextField *activeField;
- (IBAction)signout:(id)sender;
- (IBAction)b_signin:(id)sender;
- (IBAction)b_signup:(id)sender;
- (BOOL)textFieldShouldReturn:(UITextField *)textField;
@property BOOL *signinSucces;

@end
