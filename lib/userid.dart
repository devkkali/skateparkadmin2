import 'package:flutter/material.dart';
import 'package:flutter/services.dart';

import 'home.dart';
import 'login.dart';

class UserId extends StatefulWidget {
  @override
  State<UserId> createState() => _UserIdState();
}

class _UserIdState extends State<UserId> {
  TextEditingController cardnumber = TextEditingController();

  @override
  Widget build(BuildContext context) {
    return Container(
      decoration: BoxDecoration(
          image: DecorationImage(
              image: AssetImage('assets/login.png'), fit: BoxFit.cover)),
      child: Scaffold(
        backgroundColor: Colors.transparent,
        appBar: AppBar(
          title: Text('The Skate Park'),
          centerTitle: true,
          leading: Center(
            child: Center(
              child: IconButton(
                icon: Icon(
                  Icons.arrow_back,
                  color: Colors.white,
                ),
                onPressed: () {
                  Navigator.pushReplacement(
                    context,
                    MaterialPageRoute(builder: (contex) => MyLogin()),
                  );
                },
              ),
            ),
          ),
          backgroundColor: Colors.transparent,
        ),
        body: SingleChildScrollView(
          child: Column(
            children: [
              Padding(
                padding: EdgeInsets.only(
                  top: MediaQuery.of(context).size.height * 0.29,
                ),
                child: Center(
                  child: Container(
                    decoration: BoxDecoration(
                      color: Colors.blue.shade200,
                      boxShadow: const [
                        BoxShadow(
                            color: Colors.grey,
                            blurRadius: 10.0,
                            offset: Offset(10.0, 10.0)),
                      ],
                      borderRadius: BorderRadius.all(Radius.circular(10)),
                    ),
                    width: 450.0,
                    height: MediaQuery.of(context).size.height * 0.25,
                    child: SizedBox(
                      child: Padding(
                        padding: const EdgeInsets.only(
                            top: 50.0, left: 15.0, right: 15.0),
                        child: TextField(
                          inputFormatters: [
                            FilteringTextInputFormatter.digitsOnly
                          ],
                          keyboardType: TextInputType.number,
                          maxLength: 10,
                          onSubmitted: (value) {
                            Navigator.pushReplacement(
                                context,
                                MaterialPageRoute(
                                    builder: (contex) =>
                                        Home(value, 'Roshan')));
                          },
                          autofocus: true,
                          onChanged: (value) {},
                          decoration: InputDecoration(
                            fillColor: Colors.grey.shade100,
                            filled: true,
                            hintText: 'Card Number',
                            border: OutlineInputBorder(
                              borderRadius: BorderRadius.circular(10),
                            ),
                          ),
                        ),
                      ),
                    ),
                  ),
                ),
              )
            ],
          ),
        ),
      ),
    );
  }
}
