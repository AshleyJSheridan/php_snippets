#include <string.h>

int pin = 13;
int buffer_length = 10;
String buffer;

void setup()
{
	Serial.begin(9600);
	pinMode(pin, OUTPUT);
}

void loop()
{
	if (Serial.available() > 0)
	{
		char c = Serial.read();
		
		// ignore the newline - not necessary if you set no line ending in the serial monitor or you communicate directly via sockets
		//if(c != 13)
		{
			buffer = buffer + c;

			Serial.println(buffer);

			if(buffer == "aaaaa")
			{
				digitalWrite(pin, HIGH);
				buffer = "";
				delay(1000);
			}
			else
				digitalWrite(pin, LOW);
				
			if(buffer.length() > buffer_length)  // don't let the buffer grow too large and cause an out of memory error!
				buffer = "";
		}
	}
}