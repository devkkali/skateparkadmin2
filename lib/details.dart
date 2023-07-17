import 'package:flutter/material.dart';
import 'package:skatepark/main.dart';
import 'package:skatepark/userid.dart';

class ViewDetails extends StatefulWidget {
  const ViewDetails({Key? key}) : super(key: key);

  @override
  _ViewDetailsState createState() => _ViewDetailsState();
}

class _ViewDetailsState extends State<ViewDetails> {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        backwardsCompatibility: true,
        backgroundColor: Colors.grey,
        title: Padding(
          padding:
              EdgeInsets.only(left: MediaQuery.of(context).size.width * 0.2),
          child: Text('The Skate Park'),
        ),
        leading: Center(
          child: Center(
              // child: IconButton(
              //   icon: Icon(
              //     Icons.arrow_back,
              //     color: Colors.white,
              //   ),
              //   onPressed: () {
              //     Navigator.pushReplacement(
              //       context,
              //       MaterialPageRoute(
              //         builder: (contex) => Home(),
              //       ),
              //     );

              //   },
              // ),
              ),
        ),
      ),
    );
  }
}
