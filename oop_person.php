<?php 


interface PersonTemplate {
    public function sayHello() : string;
    public function sayHelloPeople(Person $first, Person $second):string;
    public function setParent( $whoIs,ParentPerson $parents);
    public function getParents();
}


class Person implements PersonTemplate {
    protected $name;
    protected $lastName;
    private $friends;
    protected $parents;

    public function __construct($name, $lastName)
    {
        $this->name = $name;
        $this->lastName = $lastName;
        $this->friends = [];
        $this->parents = [];
    }

    protected function getName() : string {
        return $this->name;
    }



    protected function getFullName() : string {
        return $this->name . ' ' . $this->lastName;
    }

    public function sayHello() : string {
        return sprintf('%s: Hello everyone!', $this->name);
    }

    public function sayHelloPeople(Person $first, Person $second):string{


        if (in_array($first, $this->friends)) {
            $firstGreeting = sprintf('Hi %s', $first->getName());
        } else {
            $this->friends[] = $first;
            $firstGreeting = sprintf('Hello my name is %s! Nice to meet you %s!', $this->getFullName(),$first->getFullName());
        };

        if (in_array($second, $this->friends)) {
            $secondGreeting = sprintf('Hi %s', $second->getName());
        } else {
            $this->friends[] = $second;
            $secondGreeting = sprintf( 'Nice to meet you %s!',$second->getFullName());
        };

        $greeting = sprintf( '%s, %s!', $firstGreeting, $secondGreeting );

        $greeting = "$this->name: " . $greeting;

        return $greeting;

    }

    public function setParent( $whoIs,ParentPerson $parents)
    {
        switch ($whoIs) {
            case 'mom':
                $parentName = $parents->getFullName();
                $this->parents['Mother'] = $parentName;
                echo "{$this->name}: My mother is {$parentName}.\n";
                break;
            case 'dad':
                $parentName = $parents->getFullName();
                $this->parents['Father'] = $parentName;
                echo "{$this->name}: My father is {$parentName}.\n";
                 break;
            default:
                echo "wrong";
                break;
        }
    }    

    public function getParents()
    {
        
       foreach($this->parents as $key=>$value){
            echo "{$key}: {$value}. \n";
        }
    }

    public function __toString(): string
    {
       $acc = '';
       foreach($this->friends as $friend){
            $acc .= $friend->getFullName() . "\n";
       };

       return "{$this->getFullName()} is familiar with:\n{$acc}";
    }
}

class ParentPerson extends Person {
    
    private $pChild = [];
    
    public function checkChild( Person $child)
    {
        $parentName = $this->getFullName();

        if (in_array($parentName, $child->parents)){
            $this->pChild[] = $child;
            $whoIs = array_search($parentName, $child->parents);
            echo "{$parentName} is {$child->getName()}'s {$whoIs}\n";
        }else{
            echo "{$parentName} is not {$child->getName()}'s parent. \n";
        }

}

public function getChild()
{
   if(count($this->pChild) == 0){
        echo "{$this->getFullName()} don't have children yet.\n";
   }else {

    foreach($this->pChild as $item){
        echo "Child of {$item->parents['Mother']} and {$item->parents['Father']} is {$item->getFullName()} \n";
   }


}
}

}

$steve = new Person('Steve', 'Rogers');
$peter = new Person('Peter', 'Parker');
$brad = new Person('Brad', 'Pitt');
$anthony = new ParentPerson('Anthony', 'Stark');
$angelina = new ParentPerson('Angelina', 'Jolie');
$thor = new ParentPerson('Thor', 'Odinson');

echo "----------sayHello-------------\n";
echo $peter->sayHello() . "\n";
echo "----------sayHelloPeople-------------\n";
echo $peter->sayHelloPeople($steve, $brad) . "\n";
echo "----------sayHelloPeople (to friends) -------------\n";
echo $peter->sayHelloPeople($steve, $brad) . "\n";
echo "----------magic method -------------\n";
echo $peter . "\n";
echo "----------setting parents-------------\n";
$peter->setParent('mom', $angelina) ;
$peter->setParent('dad', $anthony) ;
$steve->setParent('mom', $angelina) ;
$steve->setParent('dad', $anthony) ;


echo "----------getting parents-------------\n";
$peter->getParents() . "\n";
echo "----------work with inherit class (cheeking who is parent)-------------\n";

$anthony->checkChild($peter);
$angelina->checkChild($peter);
$anthony->checkChild($steve);
$anthony->checkChild($brad);

echo "----------getting children-------------\n";

$anthony->getChild();
$thor->getChild();








