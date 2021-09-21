<?php

namespace App\EventSubscriber;

use App\Repository\BokingRepository;
use CalendarBundle\CalendarEvents;
use CalendarBundle\Entity\Event;
use CalendarBundle\Event\CalendarEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class CalendarSubscriber implements EventSubscriberInterface
{
    private $boking;

    public function __construct(BokingRepository $boking)
    {
        $this->boking = $boking;
    }


    public static function getSubscribedEvents()
    {
        return [
            CalendarEvents::SET_DATA => 'onCalendarSetData',
        ];
    }

    public function onCalendarSetData(CalendarEvent $calendar)
    {


        $start = $calendar->getStart();
        $end = $calendar->getEnd();
        $filters = $calendar->getFilters();

        $var = $this->boking->reservas();
        $fechaInicio = "";
        $fechaFin = "";
        foreach ($var as $row) {
            $datosBooking = $row;
            $fechaInicio = explode('-', $datosBooking['start_date']);
            $fechaFin = explode('-', $datosBooking['end_date']);

            $fin = $fechaFin[2] + 1;

            $evento = new Event(
                $datosBooking['grupo'].'-'. $datosBooking['home'].'-'. $datosBooking['estado'],
                new \DateTime($fechaInicio[0] . '-' . $fechaInicio[1] . '-' . $fechaInicio[2]),
                new \DateTime($fechaFin[0] . '-' . $fechaFin[1] . '-' . $fin)

            );
            $evento->setOptions([
                'backgroundColor' =>  $datosBooking['color'],
                'borderColor' => '#000000',

            ]);



            $calendar->addEvent($evento);
        }
    }
            


        

     
            

        
        
      

        //SELECT user_group.name as grupo,color,boking.start_date,boking.end_date,mobile_home.name as home ,state.name as estado FROM boking,user_group,user,state,mobile_home where user_group_id=user_group.id and state_id=state.id and mobile_home.id=mobile_home_id and user.id=boking.user_id
      
/*
        $evento1->setOptions([
            'backgroundColor' => 'red',
            'borderColor' => 'red',
            'height'=>'700'
        ]);

    

 

        $calendar->addEvent($evento1);
*/
        
    
}

/*




//comparar que la fecha sea el mismo mes
        if ($fechaInicio[1] == $fechaFin[1]) {
            //$diasMes = cal_days_in_month(CAL_GREGORIAN, $fechaInicio[1], $fechaInicio[0]);
            for ($i = $fechaInicio[2]; $i <= $fechaFin[2]; $i++) {
                $evento = new Event(
                    $datosBooking['name'],
                    new \DateTime($fechaInicio[0] . '-' . $fechaInicio[1] . '-' . $i)

                );
                $evento->setOptions([
                    'backgroundColor' => 'red',
                    'borderColor' => '#' . $datosBooking['color'],
                    'contentHeight' => 1300,
                ]);
                $calendar->addEvent($evento);
            }
        } else {
            $diasMes = cal_days_in_month(CAL_GREGORIAN, $fechaInicio[1], $fechaInicio[0]);
            for ($i = $fechaInicio[2]; $i <= $diasMes; $i++) {
                $evento = new Event(
                    $datosBooking['name'],
                    new \DateTime($fechaInicio[0] . '-' . $fechaInicio[1] . '-' . $i)

                );
                $evento->setOptions([
                    'backgroundColor' => 'red',
                    'borderColor' => '#' . $datosBooking['color'],
                    'contentHeight' => 1300,
                ]);
                $calendar->addEvent($evento);
            }

            for ($i = $fechaInicio[1] $i <= $fechaFin[1]-$fechaInicio[1]; $i++) {
                $evento = new Event(
                    $datosBooking['name'],
                    new \DateTime($fechaFin[0] . '-' . $fechaFin[1] . '-' . $i)

                );
                $evento->setOptions([
                    'backgroundColor' => 'red',
                    'borderColor' => '#' . $datosBooking['color'],
                    'contentHeight' => 1300,
                ]);
                $calendar->addEvent($evento);
            }


        }*/