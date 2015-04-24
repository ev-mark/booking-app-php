<?php
/*
 ******************************************************************************
 *
 * Copyright (C) 2013 T Dispatch Ltd
 *
 * Licensed under the GPL License, Version 3.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.gnu.org/licenses/gpl-3.0.html
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 ******************************************************************************
*/

namespace TDispatch\Booking\Message;

use TDispatch\Booking\TDispatch as TDispatch;

class FareCalculation extends Message {

    public function calculateFare($pickupTime, $pickup, $dropoff, $vehicleType, $waypoints = array()) {

        $dataSend = array(
            'pickup_location' => $pickup,
            'dropoff_location' => $dropoff,
            'pickup_time' => date(DATE_ATOM, $pickupTime),
			'car_type' => $vehicleType
        );
        if (!empty($waypoints)) {
            $dataSend['way_points'] = $waypoints;
        }

        $response = $this->request($this->makeUrl("locations/fare"), $dataSend);
        $response["fare"]["fare_narrative"] = json_decode($response["fare"]["fare_narrative"], true);

        return $response;
    }

}
