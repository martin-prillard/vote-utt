//
//  UIViewController+Authentication.m
//  VoteVCMP
//
//  Created by Martin PRILLARD and Vincent COURTADE  on 10/12/13.
//  Copyright (c) 2013 Vot'UTT. All rights reserved.
//

#import "UIViewController+Authentication.h"
#import "AppDelegate.h"

@implementation UIViewController (Authentication)

//Retourne le token
-(NSString *)userToken {
    return ((AppDelegate*)[UIApplication sharedApplication].delegate).userToken;
}

//Retourne l'id de l'utilisateur
-(NSString *)userId {
    return ((AppDelegate*)[UIApplication sharedApplication].delegate).userId;
}

@end

