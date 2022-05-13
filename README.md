# Outpatient Appointment Scheduler

The purpose of this project is:

1.  Develop a Python implementation for the scheduling algorithm developed by Kaandorp / Koole [[1]](#1) and Koeleman / Koole [[2]](#2)

2.  Improve the efficiency of the computations using alternative algorithms

## Default testing parameters

We've always tested using the following schedule parameters:

`precision = 0.9999`

`N = 24  # number of patients`

`beta = 9  # average service time for a patient`

`T = 4*60  # total time`

`d = 5  # interval size`

`I = int(T/d)  # number of intervals`

`no_show = 0`

`eind = 0`

`alpha_I = 0.2`

`alpha_T = 0.4  # patient doctor centric slider`

`alpha_W = 0.4`

## Python implementation

The original code was written in PHP and offered as a [web application](https://www.gerkoole.com/OBP/appointment-scheduler.php). In the first iteration we translated the code to Python and tested its functionality.

While testing the initial Python implementation we observed very high computation times which would make it unsuitable for any real use case. As a first improvement we reviewed all the for loops and eliminated redundancies.

We noticed in the original design a Poisson distribution was being recreated in each loop. However the base parameters of the distribution were the same. Therefore, we placed these calculations outside of the loop.

The algorithm also contains a routine that generates a solution by gradually shifting one patient through the schedule to see which position is optimal based on an objective score. In the original design, each time a patent was shifted one position to the right a Markov Chain (?) was recalculated starting at the first time slot in the schedule. We realised that the schedule up until the time slot where the actual patient's shift took place the schedule and the corresponding Markov Chain was the same. We could save time by starting the recalculation from the shifted time slot.


Isaac: --- Describe parallelization ---

## Alternative algorithms

### Surrogate Model

Isaac: --- Describe surrogate model ---

### Genetic Algorithm

We implemented a genetic algorithm that builds generations of populations of possible schedules. Individual schedules are encoded as lists with length equal to the number of time slots. Each list item contains the number of patients at a particular time slot. For instance a schedule with 8 time slots and 6 patients could be encoded as `[2, 0, 1, 0, 2, 0, 0, 1]` or `[2, 0, 2, 0, 1, 0, 0, 1]`.

Each schedule is an individual in a population. A new population is created from a previous schedule. Each newly created population is called a generation. The individuals in the new generation are created by applying natural selection, crossover and mutation.

#### Natural selection

For each individual a fitness score is calculated. This is the same as the objective value from the other approaches. Using the total set of fitness scores a distribution is fitted where the fitness scores are mapped to probability scores. The highest fitness scores have the highest probabilities.

#### Crossover

From the old population two parent schedules are sampled. Schedules with a higher fitness score are more likely to be selected. Using a crossover routine, two child schedules are generated. During a crossover, patients are transferred from parent 1 to parent 2 one at a time. To maintain the fixed total balance of patients in a schedule, the second round transfers the same number of patients from parent 2 to parent 1.

The position or time slot from which patients are transferred and are transferred to depends on the number of patients in the time slots. For the parent that loses patients, time slots with high patient numbers are more likely to be chosen. For the receiving parent, time slots with smaller amounts of patients are more likely to be picked as a destination. This construction reflects the preference for schedules where patients are more spread out.

<div>

<img src="https://github.com/witusj/obp/blob/master/images/crossover.png?raw=true" width="450"/> <img src="https://github.com/witusj/obp/blob/master/images/crossover2.png?raw=true" width="450"/>

</div>

#### Mutation

Mutation is a sort of serendipity mechanism to mitigate the risk of getting stuck in a local optimum. In random cases after a crossover the algorithm might swap the patients from two different positions in the schedule.

<div>

<img src="https://github.com/witusj/obp/blob/master/images/mutation.png?raw=true" width="450"/> <img src="https://github.com/witusj/obp/blob/master/images/mutation1.png?raw=true" width="450"/>

</div>

#### Performance

Click the following chart for a performance overview. [![click here](https://github.com/witusj/obp/blob/master/images/plot1.png?raw=true)](https://witusj.github.io/obp/charts/results.html)

The charts are interactive and show for each generation the lowes fitness score together with the corresponding schedule. Also the computation times have been added. These have to be regarded as indications and are based on individual runs. However it is clear that for larger populations and number of generations the computation time increases significantly.

The largest part of the computation time is taken up by recalculating the Markov Chain for each new solution. This takes around 1.4 seconds per schedule.

One way of dealing with this is by distrbuting the computation tasks over different cores of the CPU. We tested this using 6 cores. This system reduced the calculation times radically. Click the following chart for a performance overview. [![click here](https://github.com/witusj/obp/blob/master/images/plot2.png?raw=true)](https://witusj.github.io/obp/charts/resultsprl.html)

## References

-   <a id = '1'>[1]</a> Kaandorp, G. C., & Koole, G. (2007). Optimal outpatient appointment scheduling. Health care management science, 10(3), 217-229.

-   <a id = '2'>[2]</a> Koeleman, P. M., & Koole, G. M. (2012). Optimal outpatient appointment scheduling with emergency arrivals and general service times. IIE Transactions on Healthcare Systems Engineering, 2(1), 14-30.
