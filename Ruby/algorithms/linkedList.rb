require 'dl/stack.rb'


class StackAsArray < Stack

  ## Here we can initialize our member variables (@)
  ## this is the constructer
  def initialize(lname, fname)
		@lname = lname
		@fname = fname
  end

  def each
      ptr = @head
      while not ptr.nil?
        yield ptr.datum
        ptr = ptr.succ
      end
  end

  def push (obj)
    raise ContainerFull if @count=@array.length
    @array[@count] = @obj
    count +=1

  end

  def pop
    raise ContainerEmpty if @count ==0
    @count -=1
    result = @array[@count]
    @array[@count ] = nil
    return result
  end

  def top
    raise ContainerEmpty if @count ==0
    return @array[@count -1]
  end

end



## main
##

# First lets put the array into the container
# The following is like a foreach
#

puts
presidents = ["Ford", "Carter", "Reagan", "Bush1", "Clinton", "Bush2"]
presidents.each {|prez| puts prez}

stack = StackAsArray.new
presidents.each {|prez| stack.push(prez) }

stack.each { |item| puts stack.pop}