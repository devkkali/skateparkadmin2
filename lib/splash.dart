import 'package:flutter/material.dart';

import 'login.dart';

class Splash extends StatefulWidget {
  const Splash({Key? key}) : super(key: key);

  @override
  State<Splash> createState() => _SplashState();
}

class _SplashState extends State<Splash> {
  @override
  void initState() {
    super.initState();
    _navigatetohome();
  }

  _navigatetohome() async {
    await Future.delayed(Duration(
      milliseconds: 1500,
    ));
    Navigator.pushReplacement(
        context, MaterialPageRoute(builder: (contex) => MyLogin()));
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: Center(
          child: Container(
        child: Image(
          image: AssetImage('assets/logo.png'),
        ),
      )),
    );
  }
}
