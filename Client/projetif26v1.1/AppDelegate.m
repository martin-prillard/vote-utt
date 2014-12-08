//
//  AppDelegate.m
//  VoteVCMP
//
//  Created by Martin PRILLARD and Vincent COURTADE  on 28/11/13.
//  Copyright (c) 2013 Vot'UTT. All rights reserved.
//

#import "AppDelegate.h"

@implementation AppDelegate

@synthesize userId;
@synthesize userToken;

- (BOOL)application:(UIApplication *)application didFinishLaunchingWithOptions:(NSDictionary *)launchOptions
{
    return YES;
}
							
- (void)applicationWillResignActive:(UIApplication *)application {}

- (void)applicationDidEnterBackground:(UIApplication *)application {}

- (void)applicationWillEnterForeground:(UIApplication *)application {}

- (void)applicationDidBecomeActive:(UIApplication *)application {}

- (void)applicationWillTerminate:(UIApplication *)application
{
    //DESTRUCTION DES VARIABLES D'AUTHENTIFICATIONS (lorsque l'application est détruite)
    userId = @"";
    userToken = @"";
}

@end
