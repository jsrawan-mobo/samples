require 'socket'

class HelloWorld


  ## Here we can initialize our member variables (@)
  ## this is the constructer
  def initialize(lname="hello")
		@lname = lname
  end


  def printToConsole
    print @lname
  end

  def openConnection
    server = TCPServer.open(4444)
    loop {
        self.printToConsole
        client = server.accept
        client.print("HTTP/1.1 200 OK\r\n")
        #client.print("Date: " + Time.now.ctime + "\r\n")
        client.print("Connection: close" + "\r\n")
        client.puts "Hello World says, do you know what time it is?" + "\r\n"
        client.close()
        self.printToConsole
        }
    end
end




### This is the main

stack = HelloWorld.new
stack.openConnection