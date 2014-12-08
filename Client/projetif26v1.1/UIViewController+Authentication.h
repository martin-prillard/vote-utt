//
//  UIViewController+Authentication.h
//  VoteVCMP
//
//  Created by Martin PRILLARD and Vincent COURTADE  on 10/12/13.
//  Copyright (c) 2013 Vot'UTT. All rights reserved.
//

#import <UIKit/UIKit.h>

@interface UIViewController (Authentication)

@property (readonly, nonatomic) NSString *userId;
@property (readonly, nonatomic) NSString *userToken;

@end
