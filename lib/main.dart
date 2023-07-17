import 'package:flutter/material.dart';
import 'package:skatepark/splash.dart';

void main() {
  runApp(
    MaterialApp(
      debugShowCheckedModeBanner: false,
      home: Splash(),
      // initialRoute: 'splash',
      // routes: {'splash': (context) => Splash()},
    ),
  );
}
